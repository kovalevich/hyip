<?php

class Application_Form_Passchange extends Bootstrap_Form_Vertical
{

    public function init()
    {
        $this->setName('cahgepassword');
        $this->setAction('/cahgepassword');
        $this->setMethod('post');
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $this->addElement('text', 'code', array(
            'placeholder'   => 'Код',
            'label'         => 'Код, отправленный на email',
            'required'      => true,
            'class'         => 'form-control',
            'filters'       => array(
                'StripTags', 'StripTags'
            )
        ));

        $this->addElement('password', 'password', array(
            'placeholder'   => '',
            'label'         => 'Новый пароль',
            'required'      => true,
            'class'         => 'form-control',
            'validators'    => array(
                'NotEmpty'
            )
        ));

        $this->addElement('password', 'password_confirm', array(
            'placeholder'   => '',
            'label'         => 'Повторите пароль',
            'class'         => 'form-control',
            'required'      => true,
            'prefixPath'    => array('validate'=>array('Classes_Validator'=>'Validator')),
            'validators'    => array(
                'NotEmpty',
                'PasswordConfirm'
            )
        ));

        $this->addElement('captcha', 'captcha', array(
            'label'         => 'Введите символы изображенные ниже :',
            'required'      => true,
            'class'         => 'form-control',
            'captcha'       => array(
                'captcha'   => 'Figlet',
                'wordLen'   => 4,
                'timeout'   => 300
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