<?php
class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract
{
    private $_acl = null;
    private $_auth = null;
    
    /*
     * Инициализируем данные
     */
    public function __construct(Zend_Acl $acl)
    {
        $this->_acl = $acl;
        $this->_auth = Zend_Auth::getInstance();
    }
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        
        // получаем имя текущего ресурса
        $controller =  $request->getControllerName();
        $module  =  $request->getModuleName();
        
        // получаем имя action
        $action = $request->getActionName();
        
        if ($action == 'add' && $module == 'default') {
        	$resource = "{$module}-{$controller}-{$action}";
        }
        else
        	$resource = "{$module}-{$controller}";
        

        $identity = $this->_auth->getStorage()->read();
        if ($identity && $identity->remember) {
            Classes_Cookie::set('auth_id', $identity->id);
            Classes_Cookie::set('auth_hash', $identity->password);
        }
        else {
            if (Classes_Cookie::get('auth_id') && Classes_Cookie::get('auth_hash')) {
                $mapper = new Models_Users_Mapper();
                $identity = $mapper->getUser(Classes_Cookie::get('auth_id'));
                if ($identity->password == Classes_Cookie::get('auth_hash') && $identity->status == 1) {
                    $authStorage = $this->_auth->getStorage();
                    $authStorage->write($identity);
                }
            }
        }

        Zend_Registry::set('user', $identity);
        // если в хранилище ничего нет, то значит мы имеем дело с гостем
        $role = !empty($identity->role) ? $identity->role : 'guest';

        if (!$this->_acl->has($resource))
        	return true;
        
        // если пользователь не допущен до данного ресурса,
        // то отсылаем его на страницу авторизации
        if (!$this->_acl->isAllowed($role, $resource, $action)) {
            $request->setModuleName('default')->setControllerName('auth')->setActionName('login');
        }
    }
}
