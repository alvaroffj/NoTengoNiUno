<?php

class LogController extends Zend_Controller_Action {

    public function init() {
        $request = $this->getRequest();
        $this->fb = Zend_Registry::get("facebook");
        $this->me = Array();
        $this->fb->getUser();
        $this->me["id"] = $this->fb->getUser();
        if($this->me["id"]) {
            try {
                $user_profile = $this->fb->api('/me','GET');
                if($request->getActionName()!="save") $this->_redirect("/Log/save");
            } catch(FacebookApiException $e) {
            }   
        } else {
            Zend_Registry::getInstance()->set('me', null);
            Zend_Registry::getInstance()->set('session', null);
        }
        $this->view->controlador = $request->getControllerName();
    }

    public function indexAction() {
    }

    public function saveAction() {
        $this->_helper->layout->disableLayout();
        $this->me = $this->fb->api('/me','GET');
        if($this->me) {
            $authNamespace = new Zend_Session_Namespace('Zend_Auth');
            $authNamespace->id = $this->me["id"];
            $authNamespace->name = $this->me["name"];
            $data = new Application_Model_Usuario();
            $data->setNomUsuario($this->me["first_name"]);
            $data->setApeUsuario($this->me["last_name"]);
            $data->setEmaUsuario($this->me["email"]);
            $data->setFbAccessToken($this->fb->getAccessToken());
            $data->setFbSecret($this->fb->getApiSecret());
            $data->setFbUid($this->me["id"]);
            $MP = new Application_Model_UsuarioMP();
            $nuevo = $MP->save($data);
            $this->me["id_usuario"] = $nuevo->ID_USUARIO;
            $authNamespace->id_usuario = $nuevo->ID_USUARIO;
            Zend_Registry::getInstance()->set('me', $this->me);
//            print_r($this->me);
            if($nuevo->NUEVO) {
                $proy = new Application_Model_Proyecto();
                $proy->setNomProyecto("Principal");
                $proy->setDescProyecto("Proyecto principal");
                $proy->setIdTipoMoneda(1);
                $proy->setEstadoProyecto(0);
                $MPProy = new Application_Model_ProyectoMP();
                $idPro = $MPProy->save($proy);
                
                $usPro = new Application_Model_UsuarioProyecto();
                $usPro->setIdUsuario($nuevo->ID_USUARIO);
                $usPro->setIdProyecto($idPro);
                $usPro->setIdNivelAcceso(1);
                $MPUsPro = new Application_Model_UsuarioProyectoMP();
                $MPUsPro->save($usPro);
                
                $usCat = new Application_Model_Categoria();
                $usCat->setCategoria("Sin categoria");
                $usCat->setIdProyecto($idPro);
                $MPCat = new Application_Model_CategoriaMP();
                $MPCat->save($usCat);
                
                try {
                    $this->fb->api('/me/feed', 'POST', array(
                        'link' => 'www.melogaste.com',
                        'message' => 'Estoy usando Me lo Gaste! para registrar mis finanzas, tu puedes usarlo tambien, es gratis!',
                        'icon' => 'http://www.melogaste.com/img/money_bag_ico.png',
                        'picture' => 'http://www.melogaste.com/img/money_bag.png'
                    ));
                } catch(FacebookApiException $e) {}
            }
            $this->_redirect("/Index");
        } else {
            $this->_redirect("/Log");
        }
    }

    public function inAction() {
    }
}