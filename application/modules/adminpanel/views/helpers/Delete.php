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

    /**
     */
    public function delete ($type, $obj)
    {
        $text = '';
        $url = '';
        
        $filter = new Zend_Filter_PregReplace(array('match' => '/\'|\"/',
        		                                    'replace' => ''));
        
        switch ($type) {
        	case 'category': {
        	    $text = sprintf("Удалить марку %s безвозвратно?", $filter->filter($obj->name));
        	    $url = $this->view->url(array('id'=>$obj->id), 'deletecategory');
        		break;
        	}
            case 'article': {
                $text = sprintf("Удалить статью %s безвозвратно?", $filter->filter($obj->title));
                $url = $this->view->url(array('id'=>$obj->id), 'deletearticle');
                break;
            }
            case 'site': {
                $text = sprintf("Удалить сайт %s безвозвратно?", $filter->filter($obj->title));
                $url = $this->view->url(array('id'=>$obj->id), 'deletesite');
                break;
            }
            case 'model': {
                $text = sprintf("Удалить модель %s безвозвратно?", $filter->filter($obj->name));
                $url = $this->view->url(array('id'=>$obj->id), 'deletemodel');
                break;
            }
            case 'generation': {
                $text = sprintf("Удалить поколение %s безвозвратно?", $filter->filter($obj->name));
                $url = $this->view->url(array('id'=>$obj->id), 'deletegeneration');
                break;
            }
        }
        
        $html = '<a href="#" onClick="Confirm(\'' . $text . '\', \'' . $url . '\')"><span class="glyphicon glyphicon-trash"></span></a>';
        
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
