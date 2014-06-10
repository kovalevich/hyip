<?php
/**
 *
 * @author kovalevich
 * @version
 */
require_once 'Zend/View/Interface.php';

/**
 * Status helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Usermenu
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function usermenu ()
    {
        $user = Zend_Registry::get('user');

        $html = ($user && $user->id) ?
            '<li><a href="/profile"><span class="glyphicon glyphicon-user"></span> ' . $this->view->translate('Мой кабинет') . '</a></li>
             <li class="divider"></li>
             <li><a href="/auth/logout"><span class="glyphicon glyphicon-log-out"></span> ' . $this->view->translate('Выйти') . '</a></li>'
            :
            '<li><a href="/auth/login"><span class="glyphicon glyphicon-log-in"></span> ' . $this->view->translate('Войти') . '</a></li>
             <li><a href="/registration"><span class="glyphicon glyphicon-ok-sign"></span> ' . $this->view->translate('Регистрация') . '</a></li>';

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
