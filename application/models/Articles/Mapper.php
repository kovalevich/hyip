<?php 

class Models_Articles_Mapper extends Models_Mapper
{
    
    public function __construct($id = null)
    {
    	parent::__construct('Articles');
    	if ($id) {
    		$this->getRow($id);
    	}
    	return $this;
    }

    public function getArticle($id)
    {
        $cache_id = preg_replace('[-]', '_', $id);
        if(!$article = Classes_Cache::get('article'.$cache_id)){
            $select = $this->_db->select()
                ->from (array('article'=>'articles'), array('*'))
                ->join(array('category'=>'categories'), 'category.id = article.category_id', array(
                    'category_id'=>'id',
                    'category_title'=>'title',
                ));

            $select->where('article.id = ?', $id);

            $resultSet = $this->_db->fetchRow($select);
            $article = $this->convertRow($resultSet);
            Classes_Cache::save($article, 'article'.$cache_id, array('articles'));

        }

        $this->upHits($article->id);

        return $article;
    }

    public function getArticles($category = null, $count = 5, $is_home = null){

        if(!$articles = Classes_Cache::get('articles'.$category.$count.$is_home)){
            $select = $this->_db->select()
                ->from (array('article'=>'articles'), array('*'))
                ->join(array('category'=>'categories'), 'category.id = article.category_id', array(
                    'category_title'=>'title'
                ));

            if($category)
                $select->where('category_id = ?', $category);
            if($is_home !== null)
                $select->where('home = ?', $is_home ? 1 : 0);

            $select->order('created desc');

            if ($count > 0)
                $select->limit($count);

            $resultSet = $this->_db->fetchAll($select);
            $articles = $this->convertRows($resultSet);

            Classes_Cache::save($articles, 'articles'.$category.$count.$is_home, array('articles'));
        }
        return $articles;
    }

    public function getPage ($category = null, $page = 1)
    {
        $select = $this->_db->select()
            ->from (array('article'=>'articles'), array('*'))
            ->join(array('category'=>'categories'), 'category.id = article.category_id', array(
                'category_title'=>'title'
            ))
            ->order('article.created desc');

        if ($category)
            $select->where ('article.category_id = ?', $category);

        $adapter = new Zend_Paginator_Adapter_DbSelect($select);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage ($this->_config->items_on_page);

        return $paginator;
    }

    public function convertRow($row)
    {
    	$entry = parent::convertRow($row);
        if (!$entry) return null;

        $entry->category = new Models_Categories_Model(array(
            'id'=>$row['category_id'],
            'title'=>$row['category_title']
        ));
    	return $entry;
    }
    
    public function save()
    {
    	Classes_Cache::clear(array('articles'));
    	parent::save();
    } 
    
    public function delete($id)
    {
    	Classes_Cache::clear(array('articles'));
    	parent::delete($id);
    }

    public function upHits ($id = false) {
        if ($id) {
            $this->_db->query('update `articles` set `hits` = `hits` + 1 where `id` = "' . $id . '"');
        }
    }
}

?>