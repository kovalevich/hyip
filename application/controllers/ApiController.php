<?php
include_once('simple_html_dom.php');
class ApiController extends Zend_Controller_Action
{

    private $_config;

    public function init()
    {
        $this->_config = Zend_Registry::get('_config')->project;
        header('Content-Type: application/json; charset=utf-8');
    }

    public function preDispatch()
    {
        $this->_helper->layout()->disableLayout();
    }

    public function indexAction()
    {

    }

    public function brandsAction()
    {
        $mapper_brands = new Models_Brands_Mapper();
        $popular = $mapper_brands->getBrands('popular');
        $all = $mapper_brands->getBrands('unpopular');
        $result = array(
            'popular'   =>  array(),
            'unpopular' =>  array()
        );
        foreach($popular as $entry)
        {
            $brand = array(
                'id'    =>  $entry->id,
                'name'    =>  $entry->name,
            );
            $result['popular'][] = $brand;
        }
        foreach($all as $entry)
        {
            $brand = array(
                'id'    =>  $entry->id,
                'name'    =>  $entry->name,
            );
            $result['unpopular'][] = $brand;
        }
        $this->view->json = Zend_Json::encode($result);
    }

    public function modelsAction()
    {
       /* $id = $this->getParam('brand_id');
        $mapper = new Models_Models_Mapper();
        $result = array();
        $models = $mapper->getModels($id);
        foreach($models as $entry)
        {
            $result[$entry->id] = array(
                'id'    =>  $entry->id,
                'name'    =>  $entry->name,
                'class' => $entry->id_parent_model ? 'child-model' : '',
                'prefix' => $entry->id_parent_model ? ' - ' : ''
            );
        }

        $this->view->json = Zend_Json::encode($result);*/

        $mapper = new Models_Models_Mapper();
        $result = array();
        $models = $mapper->getModels($this->getParam('brand_id'));
        foreach($models as $entry)
        {
            if(!$entry->id_parent_model) {
                $result[$entry->id] = array(
                    'id'    =>  $entry->id,
                    'name'    =>  $entry->name,
                    'submodels' => array()
                );
            }
        }
        foreach($result as $k=>$model)
        {
            foreach ($models as $entry) {

                if($entry->id_parent_model == $model['id']){
                    $result[$k]['submodels'][$entry->id] = array(
                        'id'    =>  $entry->id,
                        'name'    =>  $entry->name
                    );
                }
            }
        }
        $this->view->json = Zend_Json::encode($result);
    }

    public function generationsAction()
    {
        $mapper = new Models_Generations_Mapper();

        $result = array();
        if($this->getParam('model_id')) {
            foreach($mapper->getGenerations($this->getParam('model_id')) as $entry)
            {
                $result[$entry->id] = array(
                    'id'    =>  $entry->id,
                    'name'    =>  $entry->name,
                );
            }
        }

        if($this->getParam('generation_id')) {
            $result = $mapper->getGeneration($this->getParam('generation_id'));
        }

        $this->view->json = Zend_Json::encode($result);
    }

    public function parseAction()
    {
        $url = $this->getParam('url');
        if(preg_match('/ab.onliner.by\/car\/\d{1,}/', $url)) {
            $id = preg_replace('/\D{1,}/', '', $url);
            $html = file_get_html('http://ab.onliner.by/car/' . $id);
            $auto_add = array();
            $element = $html->find('.autoba-fastchars-ttl', 0);
            $auto_add['brand'] = preg_replace('/(^\s{1,})|(\s{1,}$)/', '', $element->plaintext);
            $auto_add['brand'] = preg_replace('/&nbsp;/', ' ', $auto_add['brand']);

            $element = $html->find('.year', 0);
            $auto_add['year'] = preg_replace('/\D{1,}/', '', $element->plaintext);

            $element = $html->find('.dist', 0);
            $auto_add['mileage'] = preg_replace('/\D{1,}/', '', $element->plaintext);

            $element = $html->find('.content p', 1);
            $info = preg_replace('/(^\s{1,})|(\s{1,}$)/', '', $element->plaintext);
            $info_arr = explode(', ', $info);
            @$auto_add['color'] = $info_arr[0];
            @$auto_add['body'] = $info_arr[1];
            @$auto_add['engine'] = preg_replace('/\s.{1,}/', '', $info_arr[2]);
            @$volume = preg_replace('/\D{1,}/', '', $info_arr[2]) * 100;
            if($volume < 500)
            {
                $volume *= 10;
            }
            $auto_add['volume'] = $volume;
            @$auto_add['transmission'] = $info_arr[3];
            @$auto_add['road'] = preg_replace('/\s.{1,}/', '', $info_arr[4]);

            $element = $html->find('.content p', 2);
            $info = preg_replace('/(^\s{1,})|(\s{1,}$)/', '', $element->plaintext);
            $info_arr = explode(', ', $info);
            $auto_add['city'] = $info_arr[0];

            $element = $html->find('.cost strong', 0);
            $auto_add['price'] = preg_replace('/\s{1,}/', '', $element->plaintext);

            $images = array();
            foreach($html->find('.autoba-msgphotos-slider-area img') as $img) {
                $images[] = preg_replace('/100x100/', 'original', $img->src);
            }
            $auto_add['images'] = $images;

            $options = array();
            foreach($html->find('.autoba-viewoptions li') as $element) {
                if($element->class != 'none') {
                    $options[] = preg_replace('/(^\s{1,})|(\s{1,}$)/', '', $element->plaintext);
                }
            }
            $auto_add['options'] = $options;

            $element = $html->find('.c-bl', 0);
            $auto_add['phone'] = preg_replace('/\D{1,}/', '', $element->plaintext);

            $auto_add['description'] = '';
            foreach($html->find('.autoba-msglongcont p') as $element){
                $auto_add['description'] .= $element->plaintext;
            }
            $auto_add['description'] = preg_replace('/(\s{2,}.{1,})|(\+.{1,})/', '', $auto_add['description']);

            $auto_add['parse_site'] = 'onliner.by';
            $auto_add['parse_id'] = $id;
            $auto_add['created'] = date('Y-m-d H:i:s');
        }

        if(preg_match('/abw.by\/allpublic\/sell\/\d{1,}/', $this->getParam('url'))) {
            echo 'abw';
            return true;
        }
        if(preg_match('/av.by\/public\/public.php\?event=View&public_id=\d{1,}/', $this->getParam('url'))) {
            echo 'av';
            return true;
        }


        if(isset($auto_add)) {
            $mapper = new Models_Ads_Mapper();
            $ad_id = $mapper->saveParsedAd($auto_add);
            if($ad_id) $this->view->ok = $ad_id;
            else {
                $this->view->errors = 'Произошла ошибка при копировании объявления. <a href="/cars/copy">Попробовать еще</a>.';
            }
            return true;
        }
        else $this->view->errors = 'Произошла ошибка при копировании объявления. <a href="/cars/copy">Попробовать еще</a>.';
    }

    public function uploadAction()
    {
        ////////////////////////////////////////////////////////////////////
        // THE SCRIPT
        ////////////////////////////////////////////////////////////////////

        //check if request is GET and the requested chunk exists or not. this makes testChunks work
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $temp_dir = 'data/uploads/'.$_GET['flowIdentifier'];
            $chunk_file = $temp_dir.'/'.$_GET['flowFilename'].'.part'.$_GET['flowChunkNumber'];
            if (file_exists($chunk_file)) {
                header("HTTP/1.0 200 Ok");
            } else
            {
                header("HTTP/1.0 404 Not Found");
            }
        }

        // loop through files and move the chunks to a temporarily created directory
        if (!empty($_FILES)) foreach ($_FILES as $file) {
            // check the error status
            if ($file['error'] != 0) {
                _log('error '.$file['error'].' in file '.$_POST['flowFilename']);
                continue;
            }

            // init the destination file (format <filename.ext>.part<#chunk>
            // the file is stored in a temporary directory
            $temp_dir = 'data/uploads/'.$_POST['flowIdentifier'];
            $dest_file = $temp_dir.'/'.$_POST['flowFilename'].'.part'.$_POST['flowChunkNumber'];

            // create the temporary directory
            if (!is_dir($temp_dir)) {
                mkdir($temp_dir, 0777, true);
            }

            // move the temporary file
            if (!move_uploaded_file($file['tmp_name'], $dest_file)) {
                _log('Error saving (move_uploaded_file) chunk '.$_POST['flowChunkNumber'].' for file '.$_POST['flowFilename']);
            } else {

                // check if all the parts present, and create the final destination file
                createFileFromChunks($temp_dir, $_POST['flowFilename'],
                    $_POST['flowChunkSize'], $_POST['flowTotalSize']);
            }
        }
    }

}


////////////////////////////////////////////////////////////////////
// THE FUNCTIONS
////////////////////////////////////////////////////////////////////

/**
 *
 * Logging operation - to a file (upload_log.txt) and to the stdout
 * @param string $str - the logging string
 */
function _log($str) {

    // log to the output
    $log_str = date('d.m.Y').": {$str}\r\n";
    echo $log_str;

    // log to file
    if (($fp = fopen('/tmp/upload_log.txt', 'a+')) !== false) {
        fputs($fp, $log_str);
        fclose($fp);
    }
}

/**
 *
 * Delete a directory RECURSIVELY
 * @param string $dir - directory path
 * @link http://php.net/manual/en/function.rmdir.php
 */
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir") {
                    rrmdir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

/**
 *
 * Check if all the parts exist, and
 * gather all the parts of the file together
 * @param string $dir - the temporary directory holding all the parts of the file
 * @param string $fileName - the original file name
 * @param string $chunkSize - each chunk size (in bytes)
 * @param string $totalSize - original file size (in bytes)
 */
function createFileFromChunks($temp_dir, $fileName, $chunkSize, $totalSize) {

    // count all the parts of this file
    $total_files = 0;
    foreach(scandir($temp_dir) as $file) {
        if (stripos($file, $fileName) !== false) {
            $total_files++;
        }
    }

    // check that all the parts are present
    // the size of the last part is between chunkSize and 2*$chunkSize
    if ($total_files * $chunkSize >=  ($totalSize - $chunkSize + 1)) {

        // create the final destination file
        if (($fp = fopen('data/uploads/'.$fileName, 'w')) !== false) {
            for ($i=1; $i<=$total_files; $i++) {
                fwrite($fp, file_get_contents($temp_dir.'/'.$fileName.'.part'.$i));
                _log('writing chunk '.$i);
            }
            fclose($fp);
            if(!preg_match('/image/', mime_content_type('data/uploads/'.$fileName))) unlink('data/uploads/'.$fileName);
        } else {
            _log('cannot create the destination file');
            return false;
        }

        // rename the temporary directory (to avoid access from other
        // concurrent chunks uploads) and than delete it
        if (rename($temp_dir, $temp_dir.'_UNUSED')) {
            rrmdir($temp_dir.'_UNUSED');
        } else {
            rrmdir($temp_dir);
        }
    }

}