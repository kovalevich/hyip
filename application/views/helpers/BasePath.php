<?php
/**
 *
 * @author evgen
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * BasePath helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_BasePath
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function basePath ($file = NULL)
    {
        $baseUrl = $domain = $subdomain = $protocol = $host = $port = NULL;

        $host = array_reverse(explode('.', $_SERVER['HTTP_HOST']));
        $domain = $host[1].'.'.$host[0];
        $subdomain = (isset($host[2]) ? $host[2] : '');
        if(getenv("HTTPS") == 'on') {
            $protocol = 'https';
            $port     = $_SERVER['SERVER_PORT'] != 443 ? ':'.$_SERVER['SERVER_PORT'] : '';
        }else{
            $protocol = 'http';
            $port     = $_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '';
        }

        // Remove trailing slashes
        if(NULL !== $file) {
            $file = '/' . ltrim($file, '/\\');
        }else{
            $file = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/';
        }
        $baseUrl = $protocol.'://'.$subdomain.'.'.$domain.$port.$file;
        return rtrim(Zend_Controller_Front::getInstance()->getBaseUrl(),'/');
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
