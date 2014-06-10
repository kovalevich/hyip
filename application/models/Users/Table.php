<?php 

class Models_Users_Table extends Models_Table
{
    
    public function __construct()
    {
    	parent::__construct('users');
    }
    
    protected $_referenceMap    = array(
    		'author' => array(
    				'columns'           => 'id',
    				'refTableClass'     => 'Models_Projects_Table',
    				'refColumns'        => 'author_id'
    		),
    		'orderuser' => array(
    				'columns'           => 'id',
    				'refTableClass'     => 'Models_Orders_Table',
    				'refColumns'        => 'user_id'
    		),
    		'purchaseuser' => array(
    				'columns'           => 'id',
    				'refTableClass'     => 'Models_Purchases_Table',
    				'refColumns'        => 'user_id'
    		),
    		'orderauthor' => array(
    				'columns'           => 'id',
    				'refTableClass'     => 'Models_Orders_Table',
    				'refColumns'        => 'author_id'
    		),
    		'paymentuser' => array(
    				'columns'           => 'id',
    				'refTableClass'     => 'Models_Payments_Table',
    				'refColumns'        => 'user_id'
    		),
    		'moneyuser' => array(
    				'columns'           => 'id',
    				'refTableClass'     => 'Models_Money_Table',
    				'refColumns'        => 'user_id'
    		),
    );
    
}

?>