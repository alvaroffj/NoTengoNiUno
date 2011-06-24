<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initRequest() {
        $this->bootstrap('FrontController');
        $front = Zend_Controller_Front::getInstance();
        $request= new Zend_Controller_Request_Http();
        $front->setRequest($request);
        
        $fb = Zend_Registry::get("facebook");
        $this->bootstrap('View');
        $view = $this->getResource('View');
        $view->facebook = new Facebook($fb);
        $this->me = null;
        if ($view->facebook->getSession()) {
            try {
                $this->uid = $view->facebook->getUser();
                $this->me = $view->facebook->api('/me');
//                $this->me_sess = Zend_Registry::get("me");
//                if($this->me_sess["id"] != $this->me["id"]) {
                    Zend_Registry::getInstance()->set('me', $this->me);
                    Zend_Registry::getInstance()->set('session', $view->facebook->getSession());
//                }
            } catch (FacebookApiException $e) {
                error_log($e);
            }
        }
        if (!$this->me) {
            $contr = $front->getRequest()->getRequestUri();
            $contr = split("/", $contr);
            if($contr[2] != "Log") {
//                echo "salto<br>";
                Zend_Registry::getInstance()->set('me', null);
                Zend_Registry::getInstance()->set('session', null);
//                $response = new Zend_Controller_Response_Http();
//                $response->setRedirect('/public/Log/in');
//                $front->setResponse($response);
                header("Location: /public/Log/in");
                die();
            }
        }
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
        $view->headTitle('No Tengo Ni $Uno')
                ->setSeparator(' :: ');
        $view->headLink()->prependStylesheet($view->BaseUrl().'/css/reset.css');
        $view->headLink()->appendStylesheet($view->BaseUrl().'/css/base.css');
        $view->headLink()->appendStylesheet($view->BaseUrl().'/css/supersized.core.css');
        $view->headLink()->appendStylesheet('http://fonts.googleapis.com/css?family=Covered+By+Your+Grace');
        $view->headLink()->headLink(array('rel' => 'favicon shortcut icon', 'href' => $view->BaseUrl().'/img/bank.ico'), 'PREPEND');
        $view->headScript()->prependFile($view->BaseUrl().'/js/jquery-1.4.2.min.js');
        $view->headScript()->appendFile($view->BaseUrl().'/js/supersized.3.1.3.core.min.js');
//        $view->headScript()->appendFile($view->BaseUrl().'/js/DD_roundies_0.0.2a-min.js');
//        $view->headScript()->appendFile($view->BaseUrl().'/js/jquery.corner.js');
        $view->headScript()->appendFile($view->BaseUrl().'/js/cufon-yui.js');
        $view->headScript()->appendFile($view->BaseUrl().'/js/fonts/rabiohead.cufonfonts.js');
        $view->headScript()->appendFile($view->BaseUrl().'/js/facebook.js');
        $view->headScript()->appendFile($view->BaseUrl().'/js/base.js');
    }

}

