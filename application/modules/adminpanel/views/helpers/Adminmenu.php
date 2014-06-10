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
class Zend_View_Helper_Adminmenu
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function adminmenu ()
    {
        $html = '';
        $html .= '
             <ul>
                <li><a href="#">Контент</a>
                    <ul>
                        <li><a href="/adminpanel/brands">Заявки на вывод</a></li>
                    </ul>
                </li>
                <li><a href="/adminpanel/clearcache">Очитить кэш</a></li>
                <li><a href="/auth/logout">Выйти</a></li>
            </ul>
                ';
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
