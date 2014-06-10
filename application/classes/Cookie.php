<?php

class Classes_Cookie
{

    public static function get($name)
    {
        $_request = Zend_Controller_Front::getInstance()->getRequest();
        return $_request->getCookie($name);
    }

    public static function clear ($cookies)
    {
        $value = '';

        $_cookie = array(
            'domain'    => '.autoa.kov',
            'expires'   => time() - 3600,
            'path'      => '/',
        );

        $_response = Zend_Controller_Front::getInstance()->getResponse();
        if (!$_response->canSendHeaders()) return false;
        if (is_string($cookies)) {
            $cookies = array($cookies => $value);
        }
        $headerCookieString = array();
        foreach($cookies as $name => $value) {
            $cook = array();
            $cook[] = $name . '=' . ( null == $value ? 'deleted' : urlencode($value) );
            $expires = 0;
            if (null == $value) {
                $expires = time() - 3600;
            }
            else if (null != $_cookie['expires']) {
                $expires = $_cookie['expires'];
            }
            if ($expires != 0) {
                $cook[] = 'expires=' . gmdate('D, j-M-Y H:i:s \G\M\T', $expires);
            }
            if (null != $_cookie['path']) {
                $cook[] = 'path=' . $_cookie['path'];
            }
            if (null != $_cookie['domain']) {
                $cook[] = 'domain=' . $_cookie['domain'];
            }
            $_response->setHeader('Set-Cookie', implode('; ', $cook));
        }
    }

    public static function set($cookies, $value = null)
    {
        $_cookie = array(
            'domain'    => '.piramid.kov',
            'expires'   => time() + 3600,
            'path'      => '/',
        );

        $_response = Zend_Controller_Front::getInstance()->getResponse();
        if (!$_response->canSendHeaders()) return false;
        if (is_string($cookies)) {
            $cookies = array($cookies => $value);
        }
        $headerCookieString = array();
        foreach($cookies as $name => $value) {
            $cook = array();
            $cook[] = $name . '=' . ( null == $value ? 'deleted' : urlencode($value) );
            $expires = 0;
            if (null == $value) {
                $expires = time() - 3600;
            }
            else if (null != $_cookie['expires']) {
                $expires = $_cookie['expires'];
            }
            if ($expires != 0) {
                $cook[] = 'expires=' . gmdate('D, j-M-Y H:i:s \G\M\T', $expires);
            }
            if (null != $_cookie['path']) {
                $cook[] = 'path=' . $_cookie['path'];
            }
            if (null != $_cookie['domain']) {
                $cook[] = 'domain=' . $_cookie['domain'];
            }
            $_response->setHeader('Set-Cookie', implode('; ', $cook));
        }
    }

}

?>