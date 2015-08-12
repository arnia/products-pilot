<?php

class UsersController extends Zend_Controller_Action {

    public function indexAction()
    {
        return $this->_helper->redirector('login', 'auth');
    }

}