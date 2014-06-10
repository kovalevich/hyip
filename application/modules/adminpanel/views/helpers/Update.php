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
class Zend_View_Helper_Update
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function update ($type, $obj)
    {

        $html = '<a href="/getdata/update/type/' . $type . '/id/' . $obj->id . '" target="_blank"><span class="glyphicon glyphicon-refresh"></span></a>';

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
