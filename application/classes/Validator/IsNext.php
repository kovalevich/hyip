<?php

class Classes_Validator_IsNext extends Zend_Validate_Abstract
{
    const NOT_NEXT = 'no next';
    
    protected $_messageTemplates = array(
        self::NOT_NEXT => 'Неверная дата. Дата должна быть позднее сегодняшнего дня',
    );
    
    public function isValid($value)
    {
        $value = (string) $value;

        if (strtotime($value) > time()) {
        	return true;
        }
        
        $this->_error(self::NOT_NEXT);
        return false;
    }
}

?>