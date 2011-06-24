<?php

class LogController extends Zend_Controller_Action {

    public function init() {
        $fb = Zend_Registry::get("facebook");
        $this->fb = new Facebook($fb);
        $this->session = $this->fb->getSession();
        $this->view->facebook = $this->fb;
        $this->view->session = $this->session;
        $this->me = null;
        if ($this->session) {
            try {
                $uid = $this->fb->getUser();
                $this->me = $this->fb->api('/me');
                Zend_Registry::getInstance()->set('me', $this->me);
                Zend_Registry::getInstance()->set('session', $this->session);
            } catch (FacebookApiException $e) {
                error_log($e);
            }
        }
        $this->view->me = $this->me;
        $request = $this->getRequest();
        if (!$this->me) {
            Zend_Registry::getInstance()->set('me', null);
            Zend_Registry::getInstance()->set('session', null);
        } else {
            if($request->getActionName()!="save") {
                $this->_redirect('Registro');
            }
        }
        $this->view->controlador = $request->getControllerName();
    }

    public function indexAction() {
    }

    public function saveAction() {
        $this->_helper->layout->disableLayout();
        $this->me = Zend_Registry::get("me");
        $this->session = Zend_Registry::get("session");
        if($this->me) {
            $data = new Application_Model_Usuario();
            $data->setNomUsuario($this->me["first_name"]);
            $data->setApeUsuario($this->me["last_name"]);
            $data->setEmaUsuario($this->me["email"]);
            $data->setFbAccessToken($this->session["access_token"]);
            $data->setFbSecret($this->session["secret"]);
            $data->setFbSessionKey($this->session["session_key"]);
            $data->setFbSig($this->session["sig"]);
            $data->setFbUid($this->session["uid"]);
//            $data->setIdTipoMoneda(1);
            $MP = new Application_Model_UsuarioMP();
            $MP->save($data);
            $this->_redirect("/Registro");
        } else {
            $this->_redirect("Log");
        }
    }

    public function inAction() {
    }

}

