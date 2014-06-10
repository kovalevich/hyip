<?php

class Models_Model
{
    public function __construct(array $options = NULL)
    {
    	$this->setOptions ($options);
    }
    
    public function __set($name, $val)
    {
    	$method = 'set'.ucfirst($name);
    	if (!method_exists($this, $method)) {
    		if (property_exists($this, $name)) {
    			$this->$name = $val;
    		}
    	}
    	else {
    		$this->$method($val);
    	}
    }
    
    public function __get($name)
    {
        $method = 'get'.ucfirst($name);
        if(method_exists($this, $method))
            return $this->$method();
        elseif (isset($this->$name)) {
    		return $this->$name;
    	}
    	else return null;
    }
    
    public function setOptions (array $options = NULL)
    {
    	if ($options != NULL) {
    		foreach ($options as $key => $value){
    			if (property_exists($this, $key)) {
    				$this->$key = $value;
    			}
    		}
    	}
    
    }

    public function getArray()
    {
        $array = array();
        foreach($this as $property => $value)
        {
            $array[$property] = $value;
        }
        return $array;
    }
}

?>