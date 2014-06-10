<?php 

class Models_Events_Model extends Models_Model
{
    
    public $id, $date, $text, $user_id, $user_balance;

    public function __construct(array $options = null)
    {
        parent::__construct($options);
    }

}