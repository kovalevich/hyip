<?php

class Application_Form_Password extends Bootstrap_Form_Vertical
{

    public function init()
    {
        $this->setName('password');
        $this->setAction('/profile/settings');
        $this->setMethod('post');
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $this->addElement('password', 'password', array(
            'placeholder'   => '',
            'label'         => 'Новый пароль',
            'required'      => true,
            'class'         => 'form-control'
        ));

        $this->addElement('password', 'password_confirm', array(
            'placeholder'   => '',
            'label'         => 'Повторите новый пароль',
            'class'         => 'form-control',
            'required'      => true,
            'prefixPath'    => array('validate'=>array('Classes_Validator'=>'Validator')),
            'validators'    => array(
                'PasswordConfirm'
            )
        ));

        $this->addElement('button', 'submit', array(
            'label'         => 'Сохранить',
            'type'          => 'submit',
            'buttonType'    => 'success',
            'icon'          => 'ok',
            'escape'        => false
        ));


    }

}

