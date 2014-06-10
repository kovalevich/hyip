<?php 

class Models_Articles_Model extends Models_Model
{
    
    public $id, $title, $text, $modified, $created, $views, $meta_title, $meta_keywords, $meta_description, $category, $hits, $home;
    
    public function __construct(array $options = null)
    {
        parent::__construct($options);
    }
    
    public function getCategoriesWay ()
    {
    	$breadcrumbs = '<li>'. $this->title . '</li>';
    
    	$category = $this->category;
    	while ($category->title != null) {
    		$breadcrumbs = '<li><a href="/category/' . $category->id . '.html" title="Перейти на страницу категории ' . $category->title . '">' . $category->title . '</a>' . $breadcrumbs;
    		$category = $category->parent;
    	}
    
    	$breadcrumbs = '<li><a href="/" ttile="Перейти на главную страницу">Главная</a></li>' . $breadcrumbs;
    
    	return $breadcrumbs;
    }
}

?>