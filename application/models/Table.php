<?php 

class Models_Table extends Zend_Db_Table_Abstract
{
    /**
     * The default table name
     */
    protected $_name;
    
    public function __construct($name)
    {
    	$this->_name = $name;
    	parent::__construct();
    	return $this;
    }
}

?>