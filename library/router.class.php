<?php

class Router
{
    private $path;
    private $defaultController;
    private $defaultAction;

    private $controller;
    private $action;
    private $arguments;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function setDefaultController($name)
    {
        $this->defaultController = $name;
    }

    public function setDefaultAction($name)
    {
        $this->defaultAction = $name;
    }

    // This method splits the path into chunks separated by / character.
    // First chunk is a controller name, second one is an action name,
    // the rest are arguments which are later passed to the controller

    public function parse()
    {
        if($this->path == null)
            $this->path = '';

        $args = explode('/', $this->path);

        $this->controller = array_shift($args);
        $this->action = array_shift($args);

        if(strlen($this->controller) < 1)
            $this->controller = $this->defaultController;

        if(strlen($this->action) < 1)
            $this->action = $this->defaultAction;

        $this->arguments = $args;
    }

    static public function buildPath($args)
    {
        return DOMAIN . '/' . implode('/', $args);
    }

    static public function go($args){
        header("Location:". DOMAIN . '/' . implode('/', $args));
        exit();
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getArguments()
    {
        return $this->arguments;
    }
}