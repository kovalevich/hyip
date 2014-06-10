<?php

class Classes_IdGenerator {
   //const BIT_MASK = '01110011';

   static public function generate() {

        $id = uniqid();
        
        $id = base_convert($id, 16, 2);
        $id = str_pad($id, strlen($id) + (8 - (strlen($id) % 8)), '0', STR_PAD_LEFT);
        
        $chunks = str_split($id, 8);
        //$mask = (int) base_convert(IDGenerator::BIT_MASK, 2, 10);
        
        $id = array();
        foreach ($chunks as $key => $chunk) {
            //$chunk = str_pad(base_convert(base_convert($chunk, 2, 10) ^ $mask, 10, 2), 8, '0', STR_PAD_LEFT);
            if ($key & 1) {  // odd
                array_unshift($id, $chunk);
            } else {         // even
                array_push($id, $chunk);
            }
        }

        return base_convert(implode($id), 2, 36);
    }
   
    static public function generatePassword($len)
    {
      	$arr = array('a','b','c','d','e','f',
      			'g','h','i','j','k','l',
      			'm','n','o','p','r','s',
      			't','u','v','x','y','z',
      			'A','B','C','D','E','F',
      			'G','H','I','J','K','L',
      			'M','N','O','P','R','S',
      			'T','U','V','X','Y','Z',
      			'1','2','3','4','5','6',
      			'7','8','9','0');
      	$pass = "";
      	for($i = 0; $i < $len; $i++)
      	{
          	$index = rand(0, count($arr) - 1);
          	$pass .= $arr[$index];
      	}
      	return $pass;
    }
}

?>