<?php

if(!file_exists(APPLICATION_PATH . '/../vendor/autoload.php')) {
    echo "The 'vendor' folder is missing. You must run 'composer update' to resolve application dependencies.\nPlease see the README for more information.\n";
    exit(1);
}
require APPLICATION_PATH . '/../vendor/autoload.php';


define("PP_CONFIG_PATH", APPLICATION_PATH . "/../");

function getBaseUrl() {

    $protocol = 'http';
    if ($_SERVER['SERVER_PORT'] == 443 || (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')) {
        $protocol .= 's';
        $protocol_port = $_SERVER['SERVER_PORT'];
    } else {
        $protocol_port = 80;
    }

    $host = $_SERVER['HTTP_HOST'];
    $port = $_SERVER['SERVER_PORT'];
    $request = $_SERVER['PHP_SELF'];
    return dirname($protocol . '://' . $host . ($port == $protocol_port ? '' : ':' . $port) . $request);
}
