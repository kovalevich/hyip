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
class Zend_View_Helper_Articleslist
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;
    
    private $class;

    /**
     */
    public function articleslist ($entries, $type = false)
    {
        $list = '';
        
        if (!$type) {
            if (count($entries) > 0) {
                $list .= '<ol class="list-unstyled">';
                foreach ($entries as $entry) {
                    $list .= '<li><a href="' . $this->view->url(array('id'=>$entry->id, 'category_id'=>$entry->category->id), 'article') . '">' . $entry->title . '</a></li>';
                }
                $list .= '</ol>';
            }
        }
        else {
            if (count($entries) > 0) {
                $list .= '<div class="lsit"> <ul>';
            	foreach ($entries as $entry) {
            		$list .= '<li><div class="date">' . $this->view->nicetime($entry->created) . '</div><div class="title"><a href="' . $this->view->url(array('id'=>$entry->id, 'category_id'=>$entry->category->id), 'article') . '">' . $entry->title . '</a></div></li>';
            	}
            	$list .= '</ul> </div>';
            }
            else {
                $list .= 'Пока нет материалов в этой категории';
            }
        }
        return $list;
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
    
    private function toogleClass ()
    {
        if ($this->class == 'even') {
        	$this->class = 'odd';
        }
        else $this->class = 'even';
        
        return $this->class;
    }
}
