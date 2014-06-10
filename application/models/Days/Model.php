<?php 

class Models_Days_Model extends Models_Model
{
    
    public $date, $percent, $additional_sum, $additional_ref_sum, $balance, $user_id;
    
    public function __construct(array $options = null)
    {
        parent::__construct($options);
    }

}