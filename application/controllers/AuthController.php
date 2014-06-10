<?php

class AuthController extends Zend_Controller_Action
{

    protected $_config = null;

    public function init()
    {
        $this->_config = Zend_Registry::get('_config');
    }

    public function indexAction()
    {
        $this->_helper->redirector('login');
    }

    public function loginAction()
    {
        $user = Zend_Registry::get('user');
        if ($user) {
            $this->_helper->redirector('index', 'index');
        }
    
    	// создаём форму и передаём её во view
    	$form = new Application_Form_Login();
    	$this->view->form = $form;

        $this->view->registration_form = new Application_Form_Registration();
    
    	// Если к нам идёт Post запрос
    	if ($this->_request->isPost() && $form->isValid($this->_request->getPost())) {

            // получаем введённые данные
            $username = $this->getRequest()->getPost('email');
            $password = md5(md5($this->getRequest()->getPost('password')).md5($this->_config->project->salt));

            $mapper = new Models_Users_Mapper();
            $identity = $mapper->findByEmail($username);
            $identity->remember = $this->_request->getParam('remember') ? true : false;

            if ($identity->password == $password) {
                // получаем экземпляр Zend_Auth
                $auth = Zend_Auth::getInstance();
                    // получаем доступ к хранилищу данных Zend
                    $authStorage = $auth->getStorage();

                    // помещаем туда информацию о пользователе,
                    // чтобы иметь к ним доступ при конфигурировании Acl
                    $authStorage->write($identity);
                    $this->_helper->redirector('index', 'profile');
            } else {
                $this->view->errMessage = 'Неверный email или пароль!';
            }
    	}
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        Classes_Cookie::clear('auth_hash');
        $this->redirect('/auth/login');
    }

    public function noaccessAction()
    {
        // action body
    }


}







