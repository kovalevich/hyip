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
class Zend_View_Helper_Delete
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;
    
    private $class;

    /**
     */
    public function delete ($type, $obj)
    {
        $html = '';
        $text = '';
        $url = '';
        
        switch ($type) {
        	case 'type': {
        	    $text = sprintf("Удалить тип %s безвозвратно?", $obj->name);
        	    $url = $this->view->url(array('id'=>$obj->id), 'deletetype');
        		break;
        	}
        	case 'project' : {
        	    $text = sprintf("Удалить проект %s безвозвратно?", $obj->name);
        	    $url = $this->view->url(array('id'=>$obj->id), 'deleteproject');
        	    break;
        	}
        }
        
        $html = '<a href="#" onClick="Confirm(\'' . $text . '\', \'' . $url . '\')">удалить</a>';
        
        return $html;
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
