<?php
/**
 *
 * @author kovalevich
 * @version 
 */
 
 
class Zend_View_Helper_FormWysiwyg extends Zend_View_Helper_FormElement
{
 
    public function formWysiwyg($name = null, $value = null, $attribs = null)
    {
        if (is_null($name) && is_null($value) && is_null($attribs)) {
            return $this;
        }
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable
 
        $html = '<textarea class="ckeditor1" name="' . $name . '">' . $value . '</textarea>';
 
        // $value значение по умолчанию
        return $html;
    }
 
}
