<?php

class Application_Form_Categoria extends Zend_Form {

    public function init() {
        $this->clearDecorators()
                ->addDecorator('FormElements')
                ->addDecorator('Form', array('class' => 'form-inline', 'id' => 'trans'))
                ->setElementDecorators(array(
                    array('ViewHelper'),
                    array('Errors'),
                    array('Description', array('tag' => 'span', 'class' => 'hint')),
                    array('Label', array('separator' => ' ', 'class' => 'label' )),
                    array('HtmlTag', array('tag' => 'div', 'class' => 'element clear')
                    ),
                ));
        $this->setMethod('post');
//
        $this->addElement('text', 'categoria', array(
            'label' => '',
            'required' => true,
            'filters' => array('StringTrim'),
            'class' => 'text-input small-input required'
        ));
//
//        $this->addElement('text', 'color', array(
//            'label' => 'Color:',
//            'required' => true,
//            'filters' => array('StringTrim'),
//            'validators' => array(
//                array('validator' => 'StringLength', 'options' => 6)
//            )
//        ));
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'description' => '<a href="#">Cancelar</a>',
            'label' => 'Guardar',
            'decorators' => array(
                array('ViewHelper'),
                array('Description', array('escape' => false, 'tag' => 'span', 'class' => 'element-cancel-link')),
                array('HtmlTag', array('tag' => 'div', 'class' => 'submit clear large green'))
            )
        ));
//
//        $this->addElement('hash', 'csrf', array(
//            'ignore' => true,
//        ));
    }

}

