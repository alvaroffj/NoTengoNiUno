<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        $authNamespace = new Zend_Session_Namespace('Zend_Auth');
        $this->view->headLink()->appendStylesheet($this->view->BaseUrl() . '/themes/base/jquery.ui.all.css');
        $this->view->headLink()->appendStylesheet($this->view->BaseUrl() . '/css/dashboard.css');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/ui/jquery.ui.core.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/ui/jquery.ui.widget.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/ui/jquery.ui.datepicker.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/ui/i18n/jquery.ui.datepicker-es.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/jquery.validate.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/ui/jquery.ui.mouse.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/ui/jquery.ui.draggable.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/jquery.number_format.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/highcharts.js');
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/dashboard.js');

        $this->me = Zend_Registry::get("me");
        if (!isset($this->me["id_usuario"])) {
            $data = new Application_Model_Usuario();
            $MP = new Application_Model_UsuarioMP();
            $MP->fetchByFb($this->me["id"], $data);
            $this->me["id_usuario"] = $data->getIdUsuario();
            $authNamespace->id_usuario = $this->me["id_usuario"];
        }
        Zend_Registry::getInstance()->set('me', $this->me);
        $request = $this->getRequest();
        $this->view->controlador = $request->getControllerName();
        $this->regMP = new Application_Model_RegistroMP();
        $this->proMP = new Application_Model_ProyectoMP();
        $pro = new Application_Model_Proyecto();
        $this->proMP->find($this->me['id_usuario'], $pro);
        $pro->setIngresos($this->regMP->fetchSumTipo(1, $pro->getIdProyecto()));
        $pro->setEgresos($this->regMP->fetchSumTipo(2, $pro->getIdProyecto()));
        $pro->setBalance($pro->getIngresos() - $pro->getEgresos());
        $this->view->proyecto = $pro;
    }

    public function indexAction() {
        $iniBal = $this->regMP->fetchBalanceHasta($this->me['id_usuario'], date("Y-m-d", mktime(0, 0, 0, date("m") - 3, date("d"), date("Y"))));
        $this->view->mainGrafico = array();
        //        foreach($cat as $c) {
        $serie[0] = "Balance";
        $serie[1] = $this->regMP->fetchBalanceTL($this->me['id_usuario'], date("Y-m-d", mktime(0, 0, 0, date("m") - 3, date("d"), date("Y"))), date("Y-m-d"), $iniBal);
        $this->view->mainGrafico[] = $serie;
        //        }
        $formReg = new Application_Form_Registro();
        $this->view->formReg = $formReg;
    }

    public function modAction() {
        
    }

    public function facebookAction() {
        $this->view->headScript()->appendFile($this->view->BaseUrl() . '/js/index_facebook.js');
        $formReg = new Application_Form_Registro();
        $this->view->formReg = $formReg;
    }
}

