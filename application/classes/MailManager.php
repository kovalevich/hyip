<?php

class Classes_MailManager
{
    protected $_zMail, $_config;
    public $template;
    
    protected function _getMail(){
    	$this->_zMail = new Zend_Mail('UTF-8');
    	return $this->_zMail;
    }
    
    public function __construct()
    {
        $this->template = new Zend_View(array('basePath'=>APPLICATION_PATH.'/views'));
        $this->_config = Zend_Registry::get('_config');
    }
    
    public function sentTemplateMail ($email, $subject, $template, $data) 
    {
        try{
            $this->template->data = $data;
            $body = $this->template->render('/mail/' . $template . '.phtml');
            $mail = $this->_getMail();
            $mail->setBodyText($body)
            ->setFrom($this->_config->project->email, $this->_config->project->sitename)
            ->addTo($email, $email)
            ->setSubject($subject)
            ->send();
        }catch (Zend_Mail_Exception $e){

		}catch (Zend_Mail_Transport_Exception $e){

		}
        
    }
    
    public function mailto ($user, $subject, $text) {
        if(trim($user->email)){
        	try{
        		$mail = $this->_getMail();
        		$mail->setBodyText($text)
        		->setFrom($this->_config->project->email, $this->_config->project->sitename)
        		->addTo($user->email, $user->email)
        		->setSubject($subject)
        		->send();
        		 
        	}catch (Zend_Mail_Exception $e){
        		//����� ������ � ����
        	}catch (Zend_Mail_Transport_Exception $e){
        		//����� ������ � ����
        	}
        }
    }
}

?>