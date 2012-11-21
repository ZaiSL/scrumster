<?php

class JsonTemplateAdapter extends \Phalcon\Mvc\View\Engine
{

    /**
     * Adapter constructor
     *
     * @param \Phalcon\Mvc\View $view
     * @param \Phalcon\DI $di
     */
    public function __construct($view, $di)
    {       
        //Initiliaze here the adapter
        parent::__construct($view, $di);        
    }

    /**
     * Renders a view using the template engine
     *
     * @param string $path
     * @param array $params
     */
    public function render($path, $params)
    {
        
        // Устанавливаем заголовки
        $response = new Phalcon\Http\Response();
        $response->setHeader("Content-Type", "application/json");
        $response->send();
        
        //Render the view
        $this->_view->setContent(json_encode($params));
    }

}
