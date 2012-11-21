<?php

namespace Ph;

use \Phalcon\Config\Adapter\Ini as PhConfig;
use \Phalcon\Loader as PhLoader;
use \Phalcon\Flash\Session as PhFlash;
use \Phalcon\Db\Adapter\Pdo\Mysql as PhMysql;
use \Phalcon\Session\Adapter\Files as PhSession;
use \Phalcon\Cache\Frontend\Data as PhCacheFront;
use \Phalcon\Cache\Backend\File as PhCacheBack;
use \Phalcon\Mvc\Application as PhApplication;
use \Phalcon\Mvc\Dispatcher as PhDispatcher;
use \Phalcon\Mvc\Router as PhRouter;
use \Phalcon\Mvc\Url as PhUrl;
use \Phalcon\Mvc\View as PhView;
use \Phalcon\Mvc\Model\Metadata\Memory as PhMetadataMemory;
use \Phalcon\Events\Manager as PhEventsManager;
use \Phalcon\Exception as PhException;

class Bootstrap
{
    private $_di;

    /**
     * Constructor
     *
     * @param $di
     */
    public function __construct($di)
    {
        $this->_di = $di;
    }

    /**
     * Runs the application performing all initializations
     *
     * @param $options
     *
     * @return mixed
     */
    public function run($options)
    {
        $loaders = array(
            'config',
            'loader',
            //'environment',
            'url',
            //'dispatcher',
            'router',
            'view',
            'database',
            'session',
        );


        foreach ($loaders as $service)
        {
            $function = 'init' . $service;

            $this->$function($options);
        }

        $application = new PhApplication();
        $application->setDI($this->_di);

        return $application->handle()->getContent();
    }

    // Protected functions

    /**
     * Initializes the config. Reads it from its location and
     * stores it in the Di container for easier access
     *
     * @param array $options
     */
    protected function initConfig($options = array())
    {

        // Create the new object
        $config = include(ROOT_PATH."/app/config/config.php");

        // Store it in the Di container
        $this->_di->set('config', $config);
    }

    /**
     * Initializes the loader
     *
     * @param array $options
     */
    protected function initLoader($options = array())
    {
        $config = $this->_di->get('config');

        // Creates the autoloader
        $loader = new PhLoader();

        $loader->registerDirs(
            array(
                ROOT_PATH . $config->application->controllersDir,
                ROOT_PATH . $config->application->modelsDir,
				ROOT_PATH . $config->application->pluginsDir,
                ROOT_PATH . $config->application->libraryDir,
            )
        );

        // Register the namespace
        $loader->registerNamespaces(
            array("Ph" => $config->application->libraryDir)
        );

        $loader->register();
    }

    /**
     * Initializes the environment
     *
     * @param array $options
     */
    protected function initEnvironment($options = array())
    {
        set_error_handler(array('\Ph\Error', 'normal'));
        set_exception_handler(array('\Ph\Error', 'exception'));
    }

    /**
     * Initializes the baseUrl
     *
     * @param array $options
     */
    protected function initUrl($options = array())
    {
        $config = $this->_di->get('config');

        /**
         * The URL component is used to generate all kind of urls in the
         * application
         */
        $this->_di->set(
            'url',
            function() use ($config)
            {
                $url = new PhUrl();
                $url->setBaseUri($config->application->baseUri);
                return $url;
            }
        );
    }

    /**
     * Initializes the dispatcher
     *
     * @param array $options
     */
    protected function initDispatcher($options = array())
    {
        $di = $this->_di;

        $this->_di->set(
            'dispatcher',
            function() use ($di) {

                $evManager = $di->getShared('eventsManager');

                /**
                 * Listening to events in the dispatcher using the
                 * Acl plugin
                 */
                $evManager->attach(
                    "dispatch:beforeException",
                    function($event, $dispatcher, $exception)
                    {
                        switch ($exception->getCode())
                        {
                            case PhDispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                            case PhDispatcher::EXCEPTION_ACTION_NOT_FOUND:
                                $dispatcher->forward(array(
                                    'controller' => 'ControllerBase',
                                    'action' => 'notFound'
                                ));
                                return false;
                        }
                    }
                );
                $dispatcher = new PhDispatcher();
                $dispatcher->setEventsManager($evManager);

                return $dispatcher;
            }
        );
    }


    public function initRouter($options = array())
    {
        $this->_di->set(
            'router',
            function()
            {
                $router = require (ROOT_PATH.'/app/config/routes.php');
                return $router;
            }
        );
    }

    /**
     * Initializes the view
     *
     * @param array $options
     */
    protected function initView($options = array())
    {
        $config = $this->_di->get('config');
        $di     = $this->_di;

        /**
         * Setup the view service
         */
        $this->_di->set(
            'view',
            function() use ($config, $di)
            {
                $view = new PhView();
                $view->setViewsDir(ROOT_PATH . $config->application->viewsDir);
                return $view;
            }
        );
    }

    /**
     * Initializes the database and netadata adapter
     *
     * @param array $options
     */
    protected function initDatabase($options = array())
    {
        $config = $this->_di->get('config');

        $this->_di->set(
            'db',
            function() use ($config)
            {

                $params = array(
                    "host"     => $config->database->host,
                    "username" => $config->database->username,
                    "password" => $config->database->password,
                    "dbname"   => $config->database->name,
                );

                $connection = new PhMysql($params);

                //$connection->execute('SET NAMES UTF8',array());
                
                return $connection;
            }
        );

        /**
         * If the configuration specify the use of metadata adapter use it or use memory otherwise
         */
        $this->_di->set(
            'modelsMetadata',
            function() use ($config)
            {
                if (isset($config->models->metadata))
                {
                    $metaDataConfig  = $config->models->metadata;
                    $metadataAdapter = 'Phalcon\Mvc\Model\Metadata\\'
                                     . $metaDataConfig->adapter;
                    return new $metadataAdapter();
                }
                else
                {
                    return new PhMetadataMemory();
                }
            }
        );
    }

    /**
     * Initializes the session
     *
     * @param array $options
     */
    protected function initSession($options = array())
    {
        $this->_di->set(
            'session',
            function()
            {
                $session = new PhSession();
                if (!$session->isStarted())
                {
                    $session->start();
                }
                return $session;
            }
        );
    }

}
