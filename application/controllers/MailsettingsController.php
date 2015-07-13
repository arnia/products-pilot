<?php

class MailsettingsController extends Controller{
    public function setupmail($error = NULL){
        $this->set('title','Login');
        $this->set('controller',$this->_controller);
        $this->set('error',$error);
        $this->_template->render();
    }

    public function addsmtp(){
        if (isset($_POST['host']) && !empty($_POST['host']) &&
            isset($_POST['port']) && !empty($_POST['port']) &&
            isset($_POST['stype']) && !empty($_POST['stype']) &&
            isset($_POST['email']) && !empty($_POST['email']) &&
            isset($_POST['password1']) && !empty($_POST['password1']) &&
            isset($_POST['password2']) && !empty($_POST['password2'])) {


            $obj = new Cript("CIO");

            $pass=$_POST['password1'];
            if(($_POST['password1'] == $_POST['password2'])){
                $cfg = array( 'host' => $_POST['host'], 'port' => $_POST['port'], 'stype' => $_POST['stype'], 'email' => $_POST['email'], 'password' => $obj->cript($pass));
                $json = json_encode($cfg);
                $this->Mailsetting->add($json);
            }
        }
        else {
            header("Location:setupmail/" . "All fields are required");
            exit();
        };
    }
}