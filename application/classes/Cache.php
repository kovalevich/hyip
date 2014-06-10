<?php

class Classes_Cache
{
    const CACHE_DIR = './tmp/';
    const TIME = null;
    
    static public function remove($id)
    {
        $frontendOptions = array('lifetime' => Classes_Cache::TIME, 'automatic_serialization' => true);
        $backendOptions = array('cache_dir' => Classes_Cache::CACHE_DIR);
        $cache = Zend_Cache::factory('Output', 'File', $frontendOptions, $backendOptions);
        $cache->remove($id);
    }
    
    static public function save($data, $id, $tags = null, $time = null)
    {
        $frontendOptions = array('lifetime' => $time ? $time : Classes_Cache::TIME, 'automatic_serialization' => true);
        $backendOptions = array('cache_dir' => Classes_Cache::CACHE_DIR);
        $cache = Zend_Cache::factory('Output', 'File', $frontendOptions, $backendOptions);
        if (!$tags) {
        	$cache->save($data, $id);
        }
        else
            $cache->save($data, $id, $tags);
    }
    
    static public function get($id)
    {
        $frontendOptions = array('lifetime' => Classes_Cache::TIME, 'automatic_serialization' => true);
        $backendOptions = array('cache_dir' => Classes_Cache::CACHE_DIR);
        $cache = Zend_Cache::factory('Output', 'File', $frontendOptions, $backendOptions);
        return $cache->load($id);
    }
    
    static public function clear ($tags = array())
    {
        $frontendOptions = array('lifetime' => Classes_Cache::TIME, 'automatic_serialization' => true);
        $backendOptions = array('cache_dir' => Classes_Cache::CACHE_DIR);
        $cache = Zend_Cache::factory('Output', 'File', $frontendOptions, $backendOptions);
        $cache->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, $tags);
    }
}

?>