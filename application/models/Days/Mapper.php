<?php 

class Models_Days_Mapper extends Models_Mapper
{
    
    public function __construct($id = null)
    {
    	parent::__construct('Days');
    	if ($id) {
    		$this->getRow($id);
    	}
    	return $this;
    }

    public function startDay($percent)
    {
        $additional_sum = 0;
        $additional_ref_sum = 0;

        $mapper_users = new Models_Users_Mapper();
        $mapper_events = new Models_Events_Mapper();
        $users = $mapper_users->getUsers();

        foreach ($users as $user)
        {
            $parent_plus = 0;
            $parent_parent_plus = 0;
            $start_balance = $mapper_users->getBalance();

            $plus = round($user->balance * $percent / 100, 2);
            $mapper_users->setBalance($user->id, $user->balance + $plus);
            $mapper_events->adEvent($user->id, 'ежедневное начисление (' . $percent . '%) +<span class="text-success">' . $plus . '$</span>');
            $this->updateDay($percent, $plus, 0, $user->id, $user->balance);


            if($user->parent_id != 0) {
                $parent_user = $mapper_users->getUser($user->parent_id);
                $parent_plus = round($plus * $this->_config->ref_1_percent / 100, 2);
                $mapper_users->setBalance($parent_user->id, $parent_user->balance + $parent_plus);
                $mapper_events->adEvent($parent_user->id, 'начисление от партнера (#' . $user->id . ') +<span class="text-success">' . $parent_plus . '$</span>');
                $this->updateDay($percent, 0, $parent_plus, $parent_user->id, $parent_user->balance);

                if($parent_user->parent_id != 0) {
                    $parent_parent_user = $mapper_users->getUser($parent_user->parent_id);
                    $parent_parent_plus = round($plus * $this->_config->ref_2_percent / 100, 2);
                    $mapper_users->setBalance($parent_parent_user->id, $parent_parent_user->balance + $parent_parent_plus);
                    $mapper_events->adEvent($parent_parent_user->id, 'начисление от партнера (#' . $parent_user->id . ') +<span class="text-success">' . $parent_parent_plus . '$</span>');
                    $this->updateDay($percent, 0, $parent_parent_plus, $parent_parent_user->id, $parent_parent_user->balance);
                }
            }
            $additional_sum += $plus;
            $additional_ref_sum += $parent_plus + $parent_parent_plus;
        }

        $this->updateDay($percent, $additional_sum, $additional_ref_sum, 0, $start_balance);
    }

    public function updateDay ($percent = 0, $additional_sum = 0, $additional_ref_sum = 0, $user_id = 0, $start_balance = 0)
    {
        $date = preg_replace('/\d{4}$/', '', strtotime(date('Y-d-m')));
        $this->getRow((int)($user_id.$date));
        if(!$this->id) {
            $this->id = (int)($user_id.$date);
            $this->additional_sum = 0;
            $this->additional_ref_sum = 0;
            $this->balance = $start_balance;
            $this->date = date('Y-m-d H:i:s', time());
        }
        $this->user_id = $user_id;
        $this->percent = $percent;
        $this->additional_sum += $additional_sum;
        $this->additional_ref_sum += $additional_ref_sum;
        $this->balance += $additional_sum + $additional_ref_sum;
        $this->save();
    }

    public function getDay($date, $user_id = 0)
    {
        $id = $this->convertDate($date, $user_id);

        $select = $this->_db->select()
            ->from (array('day'=>'days'), array('*'));
        $select->where('day.id = ?', $id);

        $resultSet = $this->_db->fetchRow($select);
        $day = $this->convertRow($resultSet);

        return $day ? $day : false;
    }

    public function getLastDay()
    {
        $select = $this->_db->select()
            ->from (array('day'=>'days'), array('*'));
        $select->order('day.id desc')
            ->limit(0,1);

        $resultSet = $this->_db->fetchRow($select);
        $day = $this->convertRow($resultSet);

        return $day;
    }

    public function getDays($from = null, $to = null, $count = null, $user_id = null){

        $from = $from ? date('Y-m-d H:i:s', strtotime($from)) : false;
        $to = $to ? date('Y-m-d H:i:s', strtotime($to)) : false;

        $select = $this->_db->select()
            ->from (array('day'=>'days'), array('*'))
            ->order('date desc');

        if($user_id)
            $select->where('day.user_id = ?', $user_id);
        else
            $select->where('day.user_id = 0');
        if($from)
            $select->where('day.id >= ?', $this->convertDate($from, $user_id));
        if($to)
            $select->where('day.id <= ?', $this->convertDate($to, $user_id));
        if($count)
            $select->limit($count);

        $resultSet = $this->_db->fetchAll($select);
        $days = $this->convertRows($resultSet);

        return $days;
    }

    public function getPage ($number = 1)
    {
        $select = $this->_db->select()
            ->from (array('day'=>'days'), array('*'));

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

    private function convertDate($date = null, $user_id = null)
    {
        return (int)($user_id . preg_replace('/\d{4}$/', '', strtotime(date('Y-d-m', strtotime($date)))));
    }
}