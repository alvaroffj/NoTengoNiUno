<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        echo "index.init<br>";
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

//    public function indexAction() {
//        $regMP = new Application_Model_RegistroMP();
//        $catMP = new Application_Model_CategoriaMP();
//        $attr = array("ID_CATEGORIA", "CATEGORIA");
//        $where = array('ID_USUARIO' => $this->me['id_usuario']);
//        $cat = $catMP->fetchAll($attr, $where);
//        $this->view->mainGrafico = array();
//        foreach($cat as $c) {
//            $serie[0] = $c->getCategoria();
//            $serie[1] = $regMP->fetchByCat($c->getIdCategoria(), $this->me['id_usuario'], '2011-01-01', '2011-01-31');
//            $this->view->mainGrafico[] = $serie;
//        }
//    }

    public function indexAction() {
        $regMP = new Application_Model_RegistroMP();
        $this->view->ing = $regMP->fetchSumTipo(1, $this->me['id_usuario']);
        $this->view->gas = $regMP->fetchSumTipo(2, $this->me['id_usuario']);
        $this->view->bal = $this->view->ing - $this->view->gas;
        $iniBal = $regMP->fetchBalanceHasta($this->me['id_usuario'], date("Y-m-d", mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"))));
        $this->view->mainGrafico = array();
//        foreach($cat as $c) {
            $serie[0] = "Balance";
            $serie[1] = $regMP->fetchBalanceTL($this->me['id_usuario'], date("Y-m-d", mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"))), date("Y-m-d"), $iniBal);
            $this->view->mainGrafico[] = $serie;
//        }
    }

    public function modAction() {
    }

}

