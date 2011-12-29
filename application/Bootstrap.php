<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initRequest() {
        $authNamespace = new Zend_Session_Namespace('Zend_Auth');
        $this->bootstrap('FrontController');
        $front = Zend_Controller_Front::getInstance();
        $request= new Zend_Controller_Request_Http();
        $front->setRequest($request);
        
        $this->bootstrap('View');
        $view = $this->getResource('View');
        $appapikey = "175385569152277";
        $appsecret = "355bb35d0ba65daf4503b462fce4c8cc";

        $facebook = array(
            'appId' => $appapikey,
            'secret' => $appsecret,
            'cookie' => true
        );
        $this->facebook = new Facebook($facebook);
        unset($_SESSION['fb_' . $this->facebook->getAppId() . '_code']);
        unset($_SESSION['fb_' . $this->facebook->getAppId() . '_access_token']);
        unset($_SESSION['fb_' . $this->facebook->getAppId() . '_user_id']);
        
        Zend_Registry::getInstance()->set('facebook', $this->facebook);
        $this->facebook->getUser();
        $this->me = Array();
        $this->me["id"] = $this->facebook->getUser();
//        print_r($this->me);
        $authNamespace->id = (isset($authNamespace->id))?$authNamespace->id:0;
//        print_r($authNamespace->id);
        if($this->me["id"] != $authNamespace->id) { //otro usuario
            if($this->me["id"]) {
                try {
                    $this->me = $this->facebook->api('/me','GET');
//                    print_r($this->me);
                    $authNamespace->id = $this->me["id"];
                    $authNamespace->name = $this->me["name"];
                } catch(FacebookApiException $e) {
                    print_r($e);
                }
                if($request->getRequestUri()=="/Log/in") header("Location:/Index");
            } else {
                unset($authNamespace->id);
                unset($authNamespace->id_usuario);
                if($request->getRequestUri()!="/Log/in") header("Location:/Log/in");
            }
        } else {
            if($this->me["id"]) {
//                echo "ses ok, login";
                $this->me["id"] = $authNamespace->id;
                $this->me["id_usuario"] = $authNamespace->id_usuario;
                $this->me["name"] = $authNamespace->name;
            } else {
//                echo "not loged<br>";
                unset($authNamespace->id);
                unset($authNamespace->id_usuario);
//                echo $request->getRequestUri()."<br>";
                if($request->getRequestUri()!="/Log/in") {
                    header("Location:/Log/in");
                    die();
                }
            }
        }
//        print_r($this->me);
        Zend_Registry::getInstance()->set('me', $this->me);
        return $request;
    }

    protected function _initDocType() {
        $this->bootstrap('View');
        $view = $this->getResource('View');
        $view->setEncoding('UTF-8');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=utf-8');
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $viewRenderer->setView($view);
        $view->doctype('XHTML1_STRICT');
        $view->headTitle('Me lo Gasté!')
                ->setSeparator(' :: ');
        $view->headLink()->prependStylesheet($view->BaseUrl().'/css/bootstrap.css');
//        $view->headLink()->headLink(array('href'=>$view->BaseUrl().'/lib/bootstrap.less', 'rel'=>'stylesheet/less'));
//        $view->headScript()->prependFile($view->BaseUrl().'/js/less-1.1.5.min.js');
        $view->headLink()->appendStylesheet($view->BaseUrl().'/css/base.css');
        $view->headLink()->appendStylesheet($view->BaseUrl().'/css/supersized.core.css');
        $view->headLink()->appendStylesheet('http://fonts.googleapis.com/css?family=Covered+By+Your+Grace');
        $view->headLink()->headLink(array('rel' => 'favicon shortcut icon', 'href' => $view->BaseUrl().'/img/money_bag_ico.ico'), 'PREPEND');
        $view->headScript()->appendFile($view->BaseUrl().'/js/supersized.3.1.3.core.min.js');
        $view->headScript()->appendFile($view->BaseUrl().'/js/jquery.tablesorter.min.js');
        $view->headScript()->prependFile($view->BaseUrl().'/js/bootstrap-twipsy.js');
        $view->headScript()->prependFile($view->BaseUrl().'/js/bootstrap-alerts.js');
        $view->headScript()->prependFile($view->BaseUrl().'/js/bootstrap-modal.js');
        $view->headScript()->prependFile($view->BaseUrl().'/js/jquery-1.7.min.js');
        $view->headScript()->prependFile('http://connect.facebook.net/es_ES/all.js');
//        $view->headScript()->appendFile($view->BaseUrl().'/js/cufon-yui.js');
//        $view->headScript()->appendFile($view->BaseUrl().'/js/fonts/rabiohead.cufonfonts.js');
        $view->headScript()->appendFile($view->BaseUrl().'/js/facebook.js');
        $view->headScript()->appendFile($view->BaseUrl().'/js/base.js');
    }
}