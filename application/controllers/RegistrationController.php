<?php

class RegistrationController extends Zend_Controller_Action
{

    protected $_config = null, $_invite = null;

    public function init()
    {
        $this->_config = Zend_Registry::get('_config');
        if($this->_request->invite) {
            Classes_Cookie::set('invite', $this->_request->invite);
            $this->_invite = $this->_request->invite;
        }
        elseif (Classes_Cookie::get('invite')) {
            $this->_invite = Classes_Cookie::get('invite');
        }
    }

    public function indexAction()
    {
        $form = new Application_Form_Registration();
        if($this->_request->isPost() && $form->isValid($this->_request->getPost())){
            $mapper = new Models_Users_Mapper();
            $mapper->getRow();
            $mapper->fill($form->getValues());
            $mapper->status = 1;
            $mapper->role = 'user';
            $mapper->created = date('Y-m-d H:i:s');
            $mapper->save();

            $this->_request->setPost(array(
                'password' => $form->password->getValue(),
                'login' => $form->email->getValue()
            ));
            $this->_forward('login', 'auth');
        }
        if($this->_invite) {
            $form->removeElement('parent_id');
            $form->addElement('hidden', 'parent_id', array(
                'value' => $this->_invite
            ));
        }
        $form->populate($this->_request->getPost());
        $this->view->form = $form;

    }

    public function forgotpassAction()
    {
        $form = new Application_Form_Email();

        if($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
            $mapper = new Models_Users_Mapper();
            $mapper->findByEmail($form->email->getValue());
            if($mapper->id) {
                $code = Classes_IdGenerator::generate();
                $mapper->forgotpass_code = $code;
                $mapper->save();
                $mail = new Classes_MailManager();
                $mail->sentTemplateMail($mapper->email, $this->view->translate('Восстановление пароля'), 'passreset', $mapper);
                $this->_redirect('/changepassword/' . $mapper->id);
            }
            else {
                $this->view->errors = 'Пользователь с таким email не найден!';
            }
        }

        $this->view->form = $form;
    }

    public function changepasswordAction()
    {
        $form = new Application_Form_Passchange();
        $mapper = new Models_Users_Mapper($this->_request->getParam('id'));
        $form->setAction('/changepassword/' . $mapper->id);

        if(!$mapper->id) {
            $this->view->errors = 'user not found';
        }

        if(!$mapper->forgotpass_code) {
            $this->view->errors = 'error';
        }

        if($this->_request->isPost() && $form->isValid($this->_request->getPost())) {
            if($form->code->getValue() == $mapper->forgotpass_code && $mapper->id) {
                $mapper->setPassword($form->password->getValue());
                $mapper->forgotpass_code = '';
                $mapper->save();
                $this->_redirect('/profile');
            }
            else {
                $this->view->errors = 'invalid code';
            }
        }
        $this->view->form = $form;
    }

}