<?php
class Controller {

    protected $_model;
    protected $_controller; // controller name
    protected $_action;
    protected $_template;

    function __construct($model, $controller, $action) {

        $this->_controller = $controller;
        $this->_action = $action;
        $this->_model = $model;

        $this->$model = new $model;
        $this->_template = new Template($this->_controller,$this->_action);
    }

    function set($name,$value) {
        $this->_template->set($name,$value);
    }

    function __destruct() {

    }
}