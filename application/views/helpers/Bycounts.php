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
class Zend_View_Helper_Bycounts
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function bycounts ($count, $form1, $form2, $form3)
    {
        $count = abs($count) % 100;
        $lcount = $count % 10;
        if ($count >= 11 && $count <= 19) return($form3);
        if ($lcount >= 2 && $lcount <= 4) return($form2);
        if ($lcount == 1) return($form1);
        return $form3;
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
