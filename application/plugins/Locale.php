<?php

class Application_Plugin_Locale extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $my_sess = new Zend_Session_Namespace('my');
        $lang = $request->getParam('lang', '');
        if ($lang) {
            $my_sess->lang = $lang;
        }
        else {
            $lang = isset($my_sess->lang) ? $my_sess->lang : null;
        }
        try {
            $locale = new Zend_Locale(Zend_Locale::BROWSER);
        } catch (Exception $e) {
            $locale = new Zend_Locale();
        }

        /*         * ********************** */
        if ($lang == 'ru')
            $loc = 'ru_RU';
        else if ($lang == 'by')
            $loc = 'be_BY';
        else {
            //$lang = $locale->getLanguage();
            $lang = 'ru';
            $loc = 'ru_Ru';
        }

        /*         * ********************** */
        $locale->setLocale($lang);
        Zend_Registry::set('Zend_Locale', $loc);


        try {
            @$translate = new Zend_Translate(
                array(
                    'adapter' => 'gettext',
                    'content' => APPLICATION_PATH . '/languages/' . $lang . '.mo',
                    'locale' => $lang
                )
            );
        } catch (Exception $e) {
            @$translate = new Zend_Translate(array(
                    'adapter' => 'gettext',
                    'content' => APPLICATION_PATH . '/languages/ru.mo',
                    'locale' => $lang
                )
            );
        }

        Zend_Registry::set('Zend_Translate', $translate);
        Zend_Registry::set('uds_lang', $lang);

    }

}