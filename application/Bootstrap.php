<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected $_frontController, $_config;

	public function __construct($application)
    {
        parent::__construct($application);

        $this->_frontController = Zend_Controller_Front::getInstance();
        $this->_config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini');
        Zend_Registry::set('_config', $this->_config);
    }

    protected function _initView()
    {
        $view = new Zend_View();
        $view->doctype('HTML5');
        $view->config = $this->_config->project;

        $view->headTitle()->setSeparator(' | ');
        $view->headTitle($this->_config->project->domen);

        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->setView($view);

        return $view;
    }
	
	protected function _initAutoload()
	{
		Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
		$autoloader = new Zend_Application_Module_Autoloader(
				array(
						'namespace' => '',
						'basePath' => APPLICATION_PATH
				)
		);
        $autoloader->addResourceType('class', 'classes/', 'Classes')
            ->addResourceType('models', 'models/', 'Models');
		return $autoloader;
	}
	
	/**
	 * used for handling top-level navigation
	 * @return Zend_Navigation
	 */
	protected function _initNavigation()
	{

        $navigation = new Zend_Config_Ini (APPLICATION_PATH . '/configs/navigation.ini');
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $container = new Zend_Navigation($navigation->pages); //var_dump($container);
        $view->navigation($container);
	
	}

    protected function _initAcl()
    {
        $acl = new Zend_Acl();

        /** user */
        $acl->add(new Zend_Acl_Resource('user'))
            ->add(new Zend_Acl_Resource('default-profile'), 'user');

        /** AdminPanel manager */
        $acl->add(new Zend_Acl_Resource('manager'))
            ->add(new Zend_Acl_Resource('adminpanel-index'), 'manager')
            ->add(new Zend_Acl_Resource('adminpanel-ads'), 'manager');

        /** AdminPanel module */
        $acl->add(new Zend_Acl_Resource('admin'))
            ->add(new Zend_Acl_Resource('adminpanel-brands'), 'admin')
            ->add(new Zend_Acl_Resource('adminpanel-clearcache'), 'admin')
            ->add(new Zend_Acl_Resource('adminpanel-generations'), 'admin')
            ->add(new Zend_Acl_Resource('adminpanel-models'), 'admin')
            ->add(new Zend_Acl_Resource('adminpanel-shopping'), 'admin');

        $acl->addRole('guest');
        $acl->addRole('user', 'guest');
        $acl->addRole('manager', 'user');
        $acl->addRole('admin', 'manager');

        $acl->allow('user', 'user');
        $acl->allow('manager', 'manager');
        $acl->allow('admin', 'admin');

        $this->_frontController->registerPlugin(new Application_Plugin_AccessCheck($acl));
    }

    protected function _initTranslate()
    {
        $this->_frontController->registerPlugin(new Application_Plugin_Locale());
    }

    protected function _initDB()
    {
        // Check that the config contains the correct database array.
        if ($this->_config->resources->db) {

            // Instantiate the DB factory
            $dbAdapter = Zend_Db::factory($this->_config->resources->db);
            $dbAdapter->query("SET NAMES UTF8");
            // Set the DB Table default adaptor for auto connection in the models
            Zend_Db_Table::setDefaultAdapter($dbAdapter);

            // Add the DB Adaptor to the registry if we need to call it outside of the modules.
            Zend_Registry::set('dbAdapter', $dbAdapter);

        }
    }
	
}