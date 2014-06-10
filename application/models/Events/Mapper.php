<?php 

class Models_Events_Mapper extends Models_Mapper
{
    
    public function __construct($id = null)
    {
    	parent::__construct('Events');
    	if ($id) {
    		$this->getRow($id);
    	}
    	return $this;
    }

    public function getEvent($id)
    {
        $cache_id = md5('event' . $id);
        if(!$event = Classes_Cache::get($cache_id)){
            $select = $this->_db->select()
                ->from (array('event'=>'events'), array('*'));

            $select->where('event.id = ?', $id);

            $resultSet = $this->_db->fetchRow($select);
            $event = $this->convertRow($resultSet);
            Classes_Cache::save($event, $cache_id, null, 24 * 60 * 60);
        }
        return $event;
    }

    public function getEvents($user_id = null, $from = null, $to = null, $count = null){

        $from = $from ? date('Y-m-d H:i:s', strtotime($from)) : false;
        $to = $to ? date('Y-m-d H:i:s', strtotime($to)) : false;

        $cache_id = md5('events' . $from . $to . $user_id);
        if(!$events = Classes_Cache::get($cache_id)){
            $select = $this->_db->select()
                ->from (array('event'=>'events'), array('*'));

            if($user_id)
                $select->where('event.user_id = ?', $user_id);
            if($from)
                $select->where('event.date >= ?', $from);
            if($to)
                $select->where('event.date <= ?', $to);
            if($count)
                $select->limit($count);

            $select->order('event.date desc');

            $resultSet = $this->_db->fetchAll($select);
            $events = $this->convertRows($resultSet);
            Classes_Cache::save($events, $cache_id, array('events'));
        }

        return $events;
    }

    public function getPage ($number = 1, $user_id = null, $from = null, $to = null)
    {
        $select = $this->_db->select()
            ->from (array('event'=>'events'), array('*'));

        if($user_id)
            $select->where('event.user_id = ?', $user_id);
        if($from)
            $select->where('event.date >= ?', $from);
        if($to)
            $select->where('event.date <= ?', $to);

        $adapter = new Zend_Paginator_Adapter_DbSelect($select);
        $page = new Zend_Paginator($adapter);
        $page->setCurrentPageNumber($number);
        $page->setItemCountPerPage ($this->_config->items_on_page);

        return $page;
    }

    public function adEvent($user_id, $text)
    {
        $this->getRow();
        $this->user_id = $user_id;
        $this->text = $text;
        $this->date = date('Y-m-d H:i:s');
        $this->save();
    }

    public function convertRow($row)
    {
    	$entry = parent::convertRow($row);
        if (!$entry) return null;

    	return $entry;
    }
    
    public function save()
    {
    	Classes_Cache::clear(array('events'));
    	parent::save();
    } 
    
    public function delete($id)
    {
    	Classes_Cache::clear(array('events'));
    	parent::delete($id);
    }

}