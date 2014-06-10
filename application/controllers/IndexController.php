<?php

class IndexController extends Zend_Controller_Action
{

    private $_config;

    public function init()
    {
        $this->_config = Zend_Registry::get('_config')->project;
    }

    public function indexAction()
    {

    }

}