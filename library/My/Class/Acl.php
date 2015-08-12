<?php

class My_Class_Acl extends Zend_Acl
{

    public function __construct()
    {
        // Add a new role called "guest"
        $this->addRole(new Zend_Acl_Role('guest'));
        // Add a role called user, which inherits from guest
        $this->addRole(new Zend_Acl_Role('user'), 'guest');
        // Add a role called admin, which inherits from user
        $this->addRole(new Zend_Acl_Role('admin'), 'user');

        // Add some resources in the form controller::action
        $this->addResource(new Zend_Acl_Resource('index'));
        $this->addResource(new Zend_Acl_Resource('users'));
        $this->addResource(new Zend_Acl_Resource('products'));
        $this->addResource(new Zend_Acl_Resource('mailsettings'));
        $this->addResource(new Zend_Acl_Resource('auth'));
        $this->addResource(new Zend_Acl_Resource('viewall'));
        $this->addResource(new Zend_Acl_Resource('view'));
        $this->addResource(new Zend_Acl_Resource('shop'));
        $this->addResource(new Zend_Acl_Resource('error'));
        $this->addResource(new Zend_Acl_Resource('verify'));

        $this->allow('guest', 'index');
        $this->allow('guest', 'error');
        $this->allow('guest', 'auth', array('login', 'signup', 'verify'));

        $this->allow('user', 'auth');
        $this->allow('user', 'products', array('index', 'shop', 'view', 'mycart'));

        $this->allow('admin');

    }
}