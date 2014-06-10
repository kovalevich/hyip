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
class Zend_View_Helper_Number
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function number ($number, $prefix = '', $postfix = '')
    {
        return $prefix . number_format($number, 2, '. ', ' ') . $postfix;
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
