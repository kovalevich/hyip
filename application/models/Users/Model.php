<?php 

class Models_Users_Model extends Models_Model
{
    
    public $id, $name, $email, $status, $role, $created, $type, $password, $remember, $balance, $parent_id, $partners;
    
    public function __construct(array $options = null)
    {
        parent::__construct($options);
    }
    
}