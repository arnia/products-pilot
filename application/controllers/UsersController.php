<?php

class UsersController extends Controller{
    public function login(){
        $this->set('title','Login');



        $this->_template->render();
    }
}