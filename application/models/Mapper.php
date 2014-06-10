<?php

class Models_Mapper
{
    protected $_dbTable;
    protected $_row;
    protected $_config;
    protected $_name;
    protected $_db;
    
    public function __construct($name = null)
    {
        $this->_name = $name;
     	$this->_config = Zend_Registry::get('_config')->project;
    	
    	$className = 'Models_' . $this->_name . '_Table';
    	$this->_dbTable = new $className();
        $this->_db = $this->_dbTable->getDefaultAdapter();
        $this->_db->getConnection()->exec("SET NAMES 'utf8'");
    }
    
    public function getNullRow()
    {
    	return $this->_dbTable->createRow();
    }
    
    public function getRow($id = NULL)
    {
        if ($id) {
        	$this->_row = $this->_dbTable->find($id)->current();
        }
        if (!$this->_row || !$id)
            $this->_row = $this->_dbTable->createRow();
        return $this->_row;
    }
    
    public function save()
    {
    	return $this->_row->save(); 
    }

    public function insert($data)
    {
        return $this->_dbTable->insert($data);
    }
    
    public function fill(array $options)
    {
        if (count($options))
        	foreach ($options as $key=>$option){
        		$this->$key = $option;
        	}
    }

    public function fill1(array $options)
    {
        if (count($options))
            foreach ($options as $key=>$option){
                if (isset($this->_row->$key))
                    $this->_row->$key = $option;
            }
    }

    public function __set($name, $val)
    {
        $method = 'set'.ucfirst($name);
        if (method_exists($this, $method)) {
            $this->$method($val);
        }
        else {
            if (isset($this->_row->$name)) {
                $this->_row->$name = $val;
            }
        }
    }
    
    public function getArray ()
    {
    	return $this->_row->toArray();
    }
    
    public function convertRows($data)
    {
    	$entries   = array();
    	if (count($data))
        	foreach ($data as $row){
        		$entries[] = $this->convertRow($row);
        	}
    	return $entries;
    }

    
    public function delete($id)
    {
    	$this->_dbTable->delete($this->_dbTable->getAdapter()->quoteInto('id = ?', $id));
    }

    public function update($name, $data, $where)
    {
        return $this->_db->update($name, $data, $where);
    }
    
    public function __get($name)
    {
    	return isset($this->_row->$name) ? $this->_row->$name : null;
    }

    public function query($query)
    {
        $this->_db->query($query);
    }
    
    public function convertRow($row = null)
    {
        if (!$row && !$this->_row) return null;

        $className = 'Models_' . $this->_name . '_Model';
        return new $className($row ? $row : $this->getArray());
    }
}

?>