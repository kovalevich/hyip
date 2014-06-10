<?php 

class Models_Cashing_Model extends Models_Model
{
    
    public $id, $user_id, $sum, $description, $status, $created, $type;
    
    public function __construct(array $options = null)
    {
        parent::__construct($options);
    }

}