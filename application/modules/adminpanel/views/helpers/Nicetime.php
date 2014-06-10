<?php
/**
 *
 * @author kovalevich
 * @version 
 */
require_once 'Zend/View/Interface.php';

/**
 * Nicetime helper
 *
 * @uses viewHelper Zend_View_Helper
 */
class Zend_View_Helper_Nicetime
{

    /**
     *
     * @var Zend_View_Interface
     */
    public $view;

    /**
     */
    public function nicetime ($date)
    {
        if ($date) {
        	return $date > 0 ? date("d.m.Y", strtotime($date)) : '' ;
        }
        else
        return '-';
        /*if(empty($date)) {
            return "No date provided";
        }
        
        $timestamp = strtotime($date);
        
        if (time() >= $timestamp) {
        	$difference = time() - $timestamp;
        	
        	$periods = array(
        			array('секунду', 'секурнды', 'секунд'),
        			array('минуту', 'минуты', 'минут'),
        			array('час', 'часа', 'часов'),
        			array('день', 'дня', 'дней'),
        			array('неделю', 'недели', 'недель'),
        			array('месяц', 'месяца', 'месяцев'),
        			array('год', 'года', 'лет'),
        			array('десятилетие', 'десятилетий', 'десятилетий'),
        	);
        	
        	$lengths = array('60','60','24','7','4.35','12','10');
        	
        	for($j = 0; $difference >= $lengths[$j]; $j++)
        		$difference /= $lengths[$j];
        	
    		$difference = round($difference);
    	
    		$cases = array (2, 0, 1, 1, 1, 2);
    		$text = $periods[$j][ ($difference%100>4 && $difference%100<20)? 2: $cases[min($difference%10, 5)] ];
        	return $difference.' '.$text . ' назад';
        }
        else {
    	    $difference = $timestamp - time();
    	    $periods = array(
    	    		array('секунда', 'секурнды', 'секунд'),
    	    		array('минуты', 'минуты', 'минут'),
    	    		array('час', 'часа', 'часов'),
    	    		array('день', 'дня', 'дней'),
    	    		array('неделя', 'недели', 'недель'),
    	    		array('месяц', 'месяца', 'месяцев'),
    	    		array('год', 'года', 'лет'),
    	    		array('десятилетие', 'десятилетий', 'десятилетий'),
    	    );
    	     
    	    $lengths = array('60','60','24','7','4.35','12','10');
    	     
    	    for($j = 0; $difference >= $lengths[$j]; $j++)
    	    	$difference /= $lengths[$j];
    	    	 
	    	$difference = round($difference);
	    	 
	    	$cases = array (2, 0, 1, 1, 1, 2);
	    	$text = $periods[$j][ ($difference%100>4 && $difference%100<20)? 2: $cases[min($difference%10, 5)] ];
	    	return 'осталось '. $difference.' '.$text;
        }*/

    }

    /**
     * Sets the view field
     * 
     * @param $view Zend_View_Interface            
     */
    public function setView (Zend_View_Interface $view)
    {
        $this->view = $view;
    }
}
