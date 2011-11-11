<?php

class Application_Form_Registro extends Zend_Form {

    public function init() {
        $authNamespace = new Zend_Session_Namespace('Zend_Auth');
        $me = Zend_Registry::get('me');
        $this->clearDecorators()
                ->addDecorator('FormElements')
                ->addDecorator('Form', array('class' => 'form', 'id' => 'trans'))
                ->setElementDecorators(array(
                    array('ViewHelper'),
                    array('Errors'),
                    array('Description', array('tag' => 'span', 'class' => 'hint')),
                    array('Label', array('separator' => ' ', 'style' => 'width: 70px; margin-right: 10px')),
                    array('HtmlTag', array('tag' => 'div', 'class' => 'clearfix')
                    ),
                ));

        $this->setMethod('post');
        
        $usProMP = new Application_Model_ProyectoMP();
        $select = $usProMP->getDbTable()->select();
        $select->from('PROYECTO')
                ->join('USUARIO_PROYECTO', 'PROYECTO.ID_PROYECTO = USUARIO_PROYECTO.ID_PROYECTO', array())
                ->where('USUARIO_PROYECTO.ID_USUARIO = ?', $authNamespace->id_usuario);
        
        $usPro = $usProMP->fetchAll($select);
//        print_r($usPro);
        $selUsPro = array();
        foreach ($usPro as $c) {
            $selUsPro[$c->getIdProyecto()] = $c->getNomProyecto();
        }
        $this->addElement('select', 'idProyecto', array(
            'label' => 'Proyecto:',
            'required' => true,
            'multiOptions' => $selUsPro,
            'class' => 'small-input'
        ));
        
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
        
        $this->addElement('text', 'fechaRegistro', array(
            'label' => 'Fecha:',
            'required' => true,
            'readonly' => true,
            'class' => 'text-input small-input required'
        ));

        $this->addElement('text', 'montoRegistro', array(
            'label' => 'Monto:',
            'required' => true,
            'class' => 'text-input small-input required number'
        ));


        $this->addElement('text', 'descRegistro', array(
            'label' => 'Descripción:',
            'required' => false,
            'class' => 'text-input small-input'
        ));

        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'description' => '<label style="width:80px;"></label><a href="#" onClick="limpiaTransaccion(); return false;" class="negativo">Cancelar</a>',
            'label' => 'Guardar',
            'class' => 'btn primary',
            'decorators' => array(
                array('ViewHelper'),
                array('Description', array('escape' => false, 'tag' => 'span', 'class' => 'element-cancel-link')),
            )
        ));

        
    }

}

