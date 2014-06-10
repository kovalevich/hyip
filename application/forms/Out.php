<?php

class Application_Form_Out extends Bootstrap_Form_Vertical
{

    public function init()
    {
        $this->setName('money');
        $this->setAction('/profile/moneyout');
        $this->setMethod('post');
        $this->setEnctype(Zend_Form::ENCTYPE_MULTIPART);

        $this->addElement('text', 'sum', array(
            'placeholder'   => '1000',
            'label'         => 'Сумма',
            'required'      => true,
            'class'         => 'form-control',
            'filters'       => array(
                'StripTags', 'StripTags'
            ),
            'validators'    => array(
                'NotEmpty'
            )
        ));

        $this->addElement('text', 'description', array(
            'placeholder'   => 'Номер кошелька',
            'label'         => 'Номер кошелька',
            'required'      => true,
            'class'         => 'form-control',
            'filters'       => array(
                'StripTags', 'StripTags'
            ),
            'validators'    => array(
                'NotEmpty'
            )
        ));

        $this->addElement('button', 'submit', array(
            'label'         => 'Подать заявку',
            'type'          => 'submit',
            'buttonType'    => 'success',
            'icon'          => 'ok',
            'escape'        => false
        ));


    }

}