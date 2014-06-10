<?php 

class Models_Cashing_Mapper extends Models_Mapper
{
    
    public function __construct($id = null)
    {
    	parent::__construct('Cashing');
    	if ($id) {
    		$this->getRow($id);
    	}
    	return $this;
    }

    public function updateCaching ($id, $status)
    {

    }

    public function getCaching($id)
    {
        $select = $this->_db->select()
            ->from (array('cashing'=>'cashing'), array('*'));
        $select->where('cashing.id = ?', $id);

        $resultSet = $this->_db->fetchRow($select);
        $day = $this->convertRow($resultSet);

        return $day ? $day : false;
    }

    public function getCashingList($user_id = null){

        $select = $this->_db->select()
            ->from (array('cashing'=>'cashing'), array('*'))
            ->where('status = 0')
            ->order('created desc');

        if($user_id)
            $select->where('user_id = ?', $user_id);

        $resultSet = $this->_db->fetchAll($select);
        $days = $this->convertRows($resultSet);

        return $days;
    }

    public function getPage ($number = 1)
    {
        $select = $this->_db->select()
            ->from (array('cashing'=>'cashing'), array('*'))
            ->where('status = 0')
            ->order('created desc');

        $adapter = new Zend_Paginator_Adapter_DbSelect($select);
        $page = new Zend_Paginator($adapter);
        $page->setCurrentPageNumber($number);
        $page->setItemCountPerPage ($this->_config->items_on_page);

        return $page;
    }

    public function convertRow($row)
    {
    	$entry = parent::convertRow($row);
        if (!$entry) return null;

    	return $entry;
    }
    
    public function save()
    {
    	parent::save();
    } 
    
    public function delete($id)
    {
    	parent::delete($id);
    }

}