<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {

        $this->view->setVar('hello','Привет упыри!');
        
    }

    public function show404()
    {
        
    }
    
}

