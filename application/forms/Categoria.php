<?php

class Application_Form_Categoria extends Zend_Form {

    public function init() {
        $authNamespace = new Zend_Session_Namespace('Zend_Auth');
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
        
        $this->addElement('text', 'categoria', array(
            'label' => '',
            'required' => true,
            'filters' => array('StringTrim'),
            'class' => 'span4 required'
        ));
        
        $usProMP = new Application_Model_ProyectoMP();
        $select = $usProMP->getDbTable()->select();
        $select->from('PROYECTO')
                ->join('USUARIO_PROYECTO', 'PROYECTO.ID_PROYECTO = USUARIO_PROYECTO.ID_PROYECTO', array())
                ->where('USUARIO_PROYECTO.ID_USUARIO = ?', $authNamespace->id_usuario);
        
        $usPro = $usProMP->fetchAll($select);
        
        $selUsPro = array();
        foreach ($usPro as $c) {
            $selUsPro[$c->getIdProyecto()] = $c->getNomProyecto();
        }
        $this->addElement('select', 'idProyecto', array(
            'label' => '',
            'required' => true,
            'multiOptions' => $selUsPro,
            'class' => 'span3'
        ));

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
            'label' => 'Agregar',
            'class' => 'btn primary',
            'decorators' => array(
                array('ViewHelper'),
                array('HtmlTag', array('tag' => 'div', 'class' => 'submit clear large green'))
            )
        ));
//
//        $this->addElement('hash', 'csrf', array(
//            'ignore' => true,
//        ));
    }

}

