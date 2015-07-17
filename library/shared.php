<?php

/** Check if environment is development and display errors **/

function initSession(){

    $session = SecureSessionHandler::getInstance("CIO");

    ini_set('session.save_handler', 'files');
    session_set_save_handler($session, true);
    session_save_path(SESSIONS);

    return $session;
}

function dbInit(){
    if( ! DEVELOPMENT_ENVIRONMENT ){
        mysqli_report(MYSQLI_REPORT_STRICT);

        global $url;

        $router = new Router($url);
        $router->setDefaultController('dbsettings');
        $router->setDefaultAction('index');
        $router->parse();

        $controller = 'dbsettings';

        if($router->getController() != 'dbsettings') {
            $action = 'index';
        }
        else{
            $action = $router->getAction();
        }


        $arguments = $router->getArguments();

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

        return false;
    }
    return true;
}

function setReporting() {
    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors','On');
        mysqli_report(MYSQLI_REPORT_STRICT);
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors','Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
    }
}


/** Main Call Function **/

function Main() {
    global $url;

    $router = new Router($url);
    $router->setDefaultController('users');
    $router->setDefaultAction('index');
    $router->parse();


    $controller = $router->getController();
    $action = $router->getAction();
    $arguments = $router->getArguments();

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

if (dbInit()) {
    setReporting();
    Main();
}
