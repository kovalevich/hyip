<?php

class Adminpanel_ClearcacheController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->headLink()->appendStylesheet('/public/styles/adminstyles.css');
    }

    public function indexAction()
    {
        Classes_Cache::clear();
    }


}

