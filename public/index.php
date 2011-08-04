<?php
require_once "../library/facebook.php";

$appapikey = "175385569152277";
$appsecret = "355bb35d0ba65daf4503b462fce4c8cc";
$appcallbackurl = "notengoniuno.flawers.me/public/";

$facebook = array(
    'appId' => $appapikey,
    'secret' => $appsecret,
//    'appcallbackurl' => $appcallbackurl,
    'cookie' => true
);


// Define path to application directory
defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
            realpath(APPLICATION_PATH . '/../library'),
            get_include_path(),
        )));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
                APPLICATION_ENV,
                APPLICATION_PATH . '/configs/application.ini'
);

$registry = Zend_Registry::getInstance()->set("facebook",$facebook);
//$font_controller = Zend_Controller_Front::getInstance();
//$font_controller->setBaseUrl("/public");

$application->bootstrap()
            ->run();