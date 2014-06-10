<?php

class Adminpanel_IndexController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        $mapper = new Models_Days_Mapper();
        $this->view->isDay = $mapper->getDay(date('Y-m-d'));
        if($this->_request->isPost() && $this->_request->percent)
        {
            $mapper->startDay($this->_request->percent);
            $this->redirect('/adminpanel');
        }
        $this->view->days = $mapper->getDays(null, null, 20);
    }

}

