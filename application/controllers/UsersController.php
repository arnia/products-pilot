<?php

class UsersController extends Controller{
    public function login($error = NULL){
        $this->set('controller',$this->_controller);
        $this->set('title','Login');
        $this->set('error',$error);
        $this->_template->render();
    }
    public function auth(){

        $error = '';

        if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $error = $this->User->auth($email,$password);

            if(!$error){

                $path = Router::buildPath('products','viewall');

                header("Location:$path");
                exit();
            }
        }
        else{
            $error = "All fields are required";
        }

        $path = Router::buildPath(array($this->_controller,'login',$error));
        header("Location:" . $path);
        exit();
    }

    public function signup($error = NULL){
        $this->set('title','Login');
        $this->set('error',$error);
        $this->set('controller',$this->_controller);

        $this->_template->render();
    }

    public function signupadd(){

    }
}