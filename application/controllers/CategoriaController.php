<?php

class CategoriaController extends Zend_Controller_Action {

    public function init() {
        $this->view->headLink()->appendStylesheet($this->view->BaseUrl() . '/themes/base/jquery.ui.all.css');
        $this->view->headLink()->appendStylesheet($this->view->BaseUrl() . '/css/categoria.css');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/ui/jquery.ui.core.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/ui/jquery.ui.widget.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/ui/jquery.ui.datepicker.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/ui/i18n/jquery.ui.datepicker-es.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/jquery.validate.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/ui/jquery.ui.mouse.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/ui/jquery.ui.draggable.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/jquery.number_format.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/jquery.jeditable.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/categoria.js');

        $this->me = Zend_Registry::get("me");
        if (!isset($this->me['id_usuario'])) {
            $us = new Application_Model_Usuario();
            $usMP = new Application_Model_UsuarioMP();
            $usMP->fetchByFb($this->me['id'], $us);
            $this->me['id_usuario'] = $us->getIdUsuario();
            Zend_Registry::getInstance()->set('me', $this->me);
        }
        $request = $this->getRequest();
        $this->view->controlador = $request->getControllerName();
    }

    public function indexAction() {
        $catMP = new Application_Model_CategoriaMP();
        $form = new Application_Form_Categoria();
        $this->view->form = $form;
        $attr = array("ID_CATEGORIA", "CATEGORIA");
        $where = array('ID_PROYECTO' => $this->me['id_usuario']);
        $this->view->cat = $catMP->fetchBalance($where);
    }

    public function addAction() {
        $request = $this->getRequest();
        $form = new Application_Form_Categoria();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $data = new Application_Model_Categoria($form->getValues());
                $data->setIdProyecto($this->me["id_usuario"]);
                $MP = new Application_Model_CategoriaMP();
                $MP->save($data);
                return $this->_helper->redirector('index');
            }
        }

        $this->view->form = $form;
    }

    public function modAction() {
        $this->_helper->layout->disableLayout();
        if ($this->getRequest()->isPost()) {
            $request = $this->getRequest();
            $data = new Application_Model_Categoria();
            $data->setIdProyecto($this->me["id_usuario"]);
            $data->setIdCategoria($request->getParam('id'));
            $data->setCategoria($request->getParam('nomCat'));
            $MP = new Application_Model_CategoriaMP();
            $MP->save($data);
            echo $data->getCategoria();
        }
    }

}

