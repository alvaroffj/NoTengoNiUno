<?php

class Application_Form_Registro extends Zend_Form {

    public function init() {
        $me = Zend_Registry::get('me');
        $this->clearDecorators()
                ->addDecorator('FormElements')
                ->addDecorator('Form', array('class' => 'form', 'id' => 'trans'))
                ->setElementDecorators(array(
                    array('ViewHelper'),
                    array('Errors'),
                    array('Description', array('tag' => 'span', 'class' => 'hint')),
                    array('Label', array('separator' => ' ', 'class' => 'label' )),
                    array('HtmlTag', array('tag' => 'div', 'class' => 'element clear')
                    ),
                ));

        $this->setMethod('post');
        $attr = array('ID_TIPO_REGISTRO', 'TIPO_REGISTRO');
        $trMP = new Application_Model_TipoRegistroMP();
        $tr = $trMP->fetchAll($attr);
        $selTr = array();
        foreach ($tr as $c) {
            $selTr[$c->getIdTipoRegistro()] = $c->getTipoRegistro();
        }
        $this->addElement('select', 'idTipoRegistro', array(
            'label' => 'Tipo:',
            'required' => true,
            'multiOptions' => $selTr,
            'class' => 'small-input'
        ));

        $attr = array('ID_CATEGORIA', 'CATEGORIA');
        $where = array('ID_PROYECTO' => $me["id_usuario"]);
        $catMP = new Application_Model_CategoriaMP();
        $cat = $catMP->fetchAll($attr, $where);
        $selCat = array();
        foreach ($cat as $c) {
            $selCat[$c->getIdCategoria()] = $c->getCategoria();
        }
        $this->addElement('select', 'idCategoria', array(
            'label' => 'Categoria:',
            'required' => true,
            'multiOptions' => $selCat,
            'class' => 'small-input'
        ));

        $this->addElement('hidden', 'idRegistro', array(
            'value' => null
        ));

        $this->addElement('text', 'montoRegistro', array(
            'label' => 'Monto:',
            'required' => true,
            'class' => 'text-input small-input required number'
        ));

        $this->addElement('text', 'fechaRegistro', array(
            'label' => 'Fecha:',
            'required' => true,
            'class' => 'text-input small-input required'
        ));

        $this->addElement('text', 'descRegistro', array(
            'label' => 'Descripción:',
            'required' => false,
            'class' => 'text-input small-input'
        ));

        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'description' => '<a href="#" onClick="limpiaTransaccion(); return false;">Cancelar</a>',
            'label' => 'Guardar',
            'decorators' => array(
                array('ViewHelper'),
                array('Description', array('escape' => false, 'tag' => 'span', 'class' => 'element-cancel-link')),
                array('HtmlTag', array('tag' => 'div', 'class' => 'submit clear large green'))
            )
        ));

        
    }

}

