<?php

class Application_Form_Login extends Bootstrap_Form_Vertical
{

    public function init()
    {
        $this->setName('login');
        $this->setAction('/auth/login');
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

        $this->addElement('password', 'password', array(
            'placeholder'   => 'Пароль',
            'label'         => 'Пароль',
            'required'      => true,
            'class'         => 'form-control',
            'validators'    => array(
                'NotEmpty'
            )
        ));

        $options = array('1' => 'Запомнить меня');
        $checkboxes = new Bootstrap_Form_Element_MultiCheckbox('remember');
        $checkboxes
            ->setLabel('')
            ->setSeparator(PHP_EOL)
            ->setMultiOptions($options);
        $this->addElement($checkboxes);

        $this->addElement('button', 'submit', array(
            'label'         => 'Войти',
            'type'          => 'submit',
            'buttonType'    => 'success',
            'icon'          => 'ok',
            'escape'        => false
        ));


    }

}