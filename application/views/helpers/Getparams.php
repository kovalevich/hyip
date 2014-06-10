<?php
/**
 *
 * @author kovalevich
 * @version
 */
require_once 'Zend/View/Interface.php';

/**
 * Nicetime helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Getparams
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function getparams ()
    {
        $params = array();
        if(Zend_Registry::isRegistered('_GET')) {
            foreach(Zend_Registry::get('_GET') as $param => $value)
            {
                if($param == 'brand') $params[] = 'brand='.$value;
                if($param == 'model') $params[] = 'model='.$value;
                if($param == 'generation') $params[] = 'generation='.$value;
                if($param == 'price') $params[] = 'price='.$value;
                if($param == 'year') $params[] = 'year='.$value;
                if($param == 'engine') $params[] = 'engine='.$value;
                if($param == 'volume') $params[] = 'volume='.$value;
                if($param == 'transmission') $params[] = 'transmission='.$value;
            }
        }
        return count($params) ? '?' . implode('&', $params) : '';
    }

    /**
     * Sets the view field
     *
     * @param $view Zend_View_Interface
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
