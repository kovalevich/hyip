<?php

class Models_Users_Mapper extends Models_Mapper
{

    public function __construct($id = null)
    {
        parent::__construct('Users');
        if ($id) {
            $this->getRow($id);
        }
        return $this;
    }

    public function setPassword($pass)
    {
        $this->_row->password = md5(md5($pass).md5($this->_config->salt));
    }

    public function setBalance($user_id, $balance)
    {
        $data = array(
            'balance' => $balance
        );
        $this->update('users', $data, 'id = ' . $user_id);

    }

    public function getPartners($user_id)
    {
        $select = $this->_db->select()
            ->from (array('user'=>'users'), array('*'))
            ->where('user.parent_id = ?', $user_id)
            ->order('user.created desc');

        $resultSet = $this->_db->fetchAll($select);
        $users = $this->convertRows($resultSet);

        foreach($users as $k=>$row)
        {
            $select = $this->_db->select()
                ->from (array('user'=>'users'), array('*'))
                ->where('user.parent_id = ?', $row->id)
                ->order('user.created desc');

            $users[$k]->partners = $this->convertRows($this->_db->fetchAll($select));
        }

        return $users;
    }

    public function getBalance()
    {
        $select = $this->_db->select()
            ->from (array('user'=>'users'), array('balance'=>'SUM(balance)'));
        $resultSet = $this->_db->fetchRow($select);
        return $resultSet['balance'];
    }

    public function getUser($id)
    {
        $select = $this->_db->select()
            ->from (array('user'=>'users'), array('*'));

        $select->where('user.id = ?', $id);

        $resultSet = $this->_db->fetchRow($select);
        $user = $this->convertRow($resultSet);

        return $user;
    }

    public function getUsers($role = null, $count = null, $balance = 0)
    {
            $select = $this->_db->select()
                ->from (array('user'=>'users'), array('*'));

            if($role)
                $select->where('role = ?', $role);

            $select->where('balance > ' . $balance);
            $select->order('created desc');

            if ($count > 0)
                $select->limit($count);

            $resultSet = $this->_db->fetchAll($select);
            $users = $this->convertRows($resultSet);

        return $users;
    }

    public function findByEmail($email)
    {
        $select = $this->_db->select()
            ->from (array('user'=>'users'), array('id'));

        $select->where('user.email = ?', $email);
        $resultSet = $this->_db->fetchRow($select);

        $this->getRow($resultSet['id']);

        return $this->convertRow($this->getArray());
    }

    public function convertRow($row)
    {
        $entry = parent::convertRow($row);
        return $entry;
    }

    public function save()
    {
        return parent::save();
    }

    public function delete($id)
    {
        parent::delete($id);
    }

}