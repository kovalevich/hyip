<?php

class ProfileController extends Zend_Controller_Action
{

    private $_user;

    public function init()
    {
        $this->_user = Zend_Registry::get('user');
        if (!$this->_user) {
            $this->_helper->redirector('index', 'index');
        }
    }

    public function indexAction()
    {
        if ($this->_user->id) {
            $mapper = new Models_Users_Mapper($this->_user->id);
            $mapper_events = new Models_Events_Mapper();
            $mapper_days = new Models_Days_Mapper();
            $this->view->events = $mapper_events->getEvents($this->_user->id, null, null, 15);
            $this->view->days = $mapper_days->getDays(null, null, null, $this->_user->id);
            $this->view->profile = $mapper->getUser($this->_user->id);
            $this->view->home = 'active';
        }
    }

    public function partnerAction()
    {
        if ($this->_user->id) {
            $mapper = new Models_Users_Mapper();
            $this->view->partners = $mapper->getPartners($this->_user->id);
            $this->view->id = $this->_user->id;
        }
    }

    public function settingsAction()
    {
        if ($this->_user->id) {
            $form = new Application_Form_Profile();
            $form_password = new Application_Form_Password();

            $mapper = new Models_Users_Mapper($this->_user->id);
            if($this->_request->isPost() && !$this->_request->password && $form->isValid($this->_request->getPost())) {
                $mapper->fill($form->getValues());
                $mapper->save();
            }
            else
                if($this->_request->getPost() && $form_password->isValid($this->_request->getPost()))
                {
                    $mapper->setPassword($form_password->password->getValue());
                    $mapper->save();
                }

            $form->populate($mapper->getArray());
            $this->view->form = $form;
            $this->view->form_password = $form_password;
        }
    }

    public function requestsAction()
    {
        $mapper = new Models_Cashing_Mapper();
        $this->view->cashing = $mapper->getCashingList($this->_user->id);
    }

    public function historyAction()
    {
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('controls.phtml');
        if ($this->_user->id) {
            $mapper = new Models_Events_Mapper();
            $this->view->page = $mapper->getPage($this->getParam('page', 1), $this->_user->id);
            $this->view->events = $mapper->convertRows($this->view->page);
        }
    }

    public function moneyoutAction()
    {
        $mapper = new Models_Cashing_Mapper();
        $mapper_user = new Models_Users_Mapper($this->_user->id);
        $form = new Application_Form_Out();
        if($this->_request->isPost() && $form->isValid($this->_request->getPost())){
            if($mapper_user->balance < abs($form->sum->getValue())) {
                $this->view->error = 'Недостаточно средств';
                return true;
            }
            $mapper->getRow();
            $mapper->fill($form->getValues());
            $mapper->user_id = $this->_user->id;
            $mapper->created = date('Y-m-d H:i:s');
            $mapper->type = 1;
            $mapper->status = 0;
            $mapper->save();

            $new_balance = $mapper_user->balance - abs($form->sum->getValue());
            $mapper_user->setBalance($this->_user->id, $new_balance);

            $mapper_event = new Models_Events_Mapper();
            $mapper_event->adEvent($this->_user->id, 'подана заявка на вывод стредств <span class="text-danger">-' . $mapper->sum . '$</span>');

            $mapper_day = new Models_Days_Mapper();
            $mapper_day->updateDay(0, -abs($form->sum->getValue()), 0, $this->_user->id);
            $this->redirect('/profile');
        }

        $this->view->form = $form;
    }


}