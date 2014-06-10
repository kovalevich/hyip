<?php

class Application_Form_Registration extends Bootstrap_Form_Vertical
{

    public function init()
    {
        $this->setName('registration');
        $this->setAction('registration');
        $this->setMethod('post');
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $this->addElement('text', 'name', array(
            'placeholder'   => 'Имя',
            'label'         => 'Имя',
            'required'      => true,
            'class'         => 'form-control',
            'filters'       => array(
                'StripTags', 'StripTags'
            )
        ));

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
                'EmailAddress', array(
                    'Db_NoRecordExists', false, array(
                        'table'=>'users',
                        'field'=>'email',
                    )
                )
            )
        ));

        $this->addElement('password', 'password', array(
            'placeholder'   => 'Пароль',
            'label'         => 'Пароль',
            'required'      => true,
            'class'         => 'form-control',
            'validators'    => array(
                'NotEmpty'
            )
        ));

        $this->addElement('password', 'password_confirm', array(
            'placeholder'   => 'Повторите пароль',
            'label'         => 'Повторите пароль',
            'class'         => 'form-control',
            'required'      => true,
            'prefixPath'    => array('validate'=>array('Classes_Validator'=>'Validator')),
            'validators'    => array(
                'NotEmpty',
                'PasswordConfirm'
            )
        ));

        $this->addElement('text', 'parent_id', array(
            'placeholder'   => '',
            'label'         => 'Пригласительный код',
            'class'         => 'form-control',
        ));

        $this->addElement('button', 'submit', array(
            'label'         => 'Регистрация',
            'type'          => 'submit',
            'buttonType'    => 'success',
            'icon'          => 'ok',
            'escape'        => false
        ));
        

    }

}


