<?php

class Application_Form_Profile extends Bootstrap_Form_Vertical
{

    public function init()
    {
        $this->setName('profile');
        $this->setAction('/profile/settings');
        $this->setMethod('post');
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $this->addElement('text', 'name', array(
            'placeholder'   => 'Иван',
            'label'         => 'Имя',
            'required'      => true,
            'class'         => 'form-control',
            'filters'       => array(
                'StripTags', 'StripTags'
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

