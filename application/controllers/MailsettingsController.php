<?php

class MailsettingsController extends Controller{
    public function setup($error = NULL){
        $this->set('title','SETUP');
        $this->set('controller',$this->_controller);
        $this->set('error',$error);
        $this->_template->render();
    }

    public function add(){
        if (isset($_POST['host']) && !empty($_POST['host']) &&
            isset($_POST['port']) && !empty($_POST['port']) &&
            isset($_POST['stype']) && !empty($_POST['stype']) &&
            isset($_POST['email']) && !empty($_POST['email']) &&
            isset($_POST['password1']) && !empty($_POST['password1']) &&
            isset($_POST['password2']) && !empty($_POST['password2'])) {

            $obj = new Cript();

            $pass=$_POST['password1'];
            if(($_POST['password1'] == $_POST['password2'])){
                $cfg = array( 'host' => $_POST['host'], 'port' => $_POST['port'], 'stype' => $_POST['stype'], 'email' => $_POST['email'], 'password' => $obj->cript($pass));
                $json = json_encode($cfg);
                $this->Mailsetting->add($json);

                //var_dump($obj->cript($pass));
                //var_dump($obj->decript($obj->cript($pass)));

                header("Location:" . Router::buildPath(array('users','login')));
                exit();
            }
            else {
                header("Location:" . Router::buildPath(array($this->_controller,'setup','Passwords must be identical')));
                exit();
            }
        }
        else {
            header("Location:setup/" . "All fields are required");
            exit();
        };
    }
}