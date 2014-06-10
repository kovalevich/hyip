<?php

class Application_Form_Email extends Bootstrap_Form_Vertical
{

    public function init()
    {
        $this->setName('login');
        $this->setAction('/registration/forgotpass');
        $this->setMethod('post');
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $this->addElement('text', 'email', array(
            'placeholder'   => 'email',
            'label'         => 'email',
            'required'      => true,
            'class'         => 'form-control',
            'filters'       => array(
                'StripTags', 'StripTags'
            ),
            'validators'    => array(
                'NotEmpty',
                'EmailAddress'
            )
        ));

        $this->addElement('button', 'submit', array(
            'label'         => 'Отправить',
            'type'          => 'submit',
            'buttonType'    => 'success',
            'icon'          => 'ok',
            'escape'        => false
        ));


    }

}