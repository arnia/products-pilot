<?php

/** Check if environment is development and display errors **/

function setReporting() {
    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors','On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors','Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
    }
}

function initSession(){

    $session = SecureSessionHandler::getInstance("CIO");

    ini_set('session.save_handler', 'files');
    session_set_save_handler($session, true);
    session_save_path(SESSIONS);

    return $session;
}

/** Main Call Function **/

function Main() {
    global $url;

    $router = new Router($url);
    $router->parse();

    $controller = $router->getController();
    $action = $router->getAction();
    $arguments = $router->getArguments();

    /*
     * $router->setDefaultController('Index');
       $router->setDefaultAction('index');
     */

    $session = initSession();

    $controllerName = $controller;
    $controller = ucwords($controller);
    $model = rtrim($controller, 's');
    $controller .= 'Controller';
    $dispatch = new $controller($model,$controllerName,$action,$session);

    if ((int)method_exists($controller, $action)) {
        call_user_func_array(array($dispatch,$action),$arguments);
    } else {
        /* Error Generation Code Here */
    }
}

/** Autoload any classes that are required **/

function __autoload($className) {
    if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
        require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
    } elseif (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
    } elseif (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) {
        require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
    } elseif (file_exists(ROOT . DS . 'library' . DS . 'mailer' . DS . 'class.' . strtolower($className) . '.php')) {
            require_once(ROOT . DS . 'library' . DS . 'mailer' . DS . 'class.' . strtolower($className) . '.php');
    } else {
        /* Error Generation Code Here */
    }
}

setReporting();
Main();