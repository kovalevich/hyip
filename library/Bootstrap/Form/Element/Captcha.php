<?php

/**
 * @category    Forms
 * @package     Twitter_Bootstrap_Form
 * @subpackage  Element
 * @author      Rafał Gałka <rafal.galka@modernweb.pl>
 */

/**
 * Captcha Form element.
 *
 * Supports the order of decorator FieldSize and duplicate text box.
 *
 * @category    Forms
 * @package     Twitter_Bootstrap_Form
 * @subpackage  Element
 * @author      Rafał Gałka <rafal.galka@modernweb.pl>
 */
class Bootstrap_Form_Element_Captcha extends Zend_Form_Element_Captcha
{
    /**
     * Render form element
     *
     * @param  Zend_View_Interface $view
     * @return string
     */
    public function render(Zend_View_Interface $view = null)
    {
        $captcha    = $this->getCaptcha();
        $captcha->setName($this->getFullyQualifiedName());

        if (!$this->loadDefaultDecoratorsIsDisabled()) {

            // fieldSize decorator mus be first
            $fieldSize = $this->getDecorator('FieldSize');
            $this->removeDecorator('FieldSize');

            // duplicated text field generated by ViewHelper decorator
            $this->removeDecorator('ViewHelper');

            $decorators = $this->getDecorators();
            $decorator = $captcha->getDecorator();
            $key = get_class($this->_getDecorator($decorator, null));

            if (!empty($decorator) && !array_key_exists($key, $decorators)) {
                array_unshift($decorators, $decorator);
            }

            $decorator = array('Captcha', array('captcha' => $captcha));
            $key = get_class($this->_getDecorator($decorator[0], $decorator[1]));

            if ($captcha instanceof Zend_Captcha_Word && !array_key_exists($key, $decorators)) {
                array_unshift($decorators, $decorator);
            }

            array_unshift($decorators, $fieldSize);
            $this->setDecorators($decorators);
        }

        $this->setValue($this->getCaptcha()->generate());

        return parent::render($view);
    }

}
