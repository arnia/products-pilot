<?php

class MailsettingsController extends Controller{

    public function viewall(){
        if(!$this->_session->isAdmin()){
            //var_dump("dasdsa");
            //$this->_template->render();
            $this->gotologin();
        }
        else{
            $this->set('title','Users Account');
            $this->set('controller',$this->_controller);
            $this->set('settings',$this->Mailsetting->getAllSettings());


            if($success = $this->_session->getDelete('success')) $this->set('success',$success);
            if($error = $this->_session->getDelete('error')) $this->set('error',$error);


            $this->_template->render();
        }
    }

    public function setup(){
        if(!$this->_session->isAdmin()){
            $this->gotologin();
        }
        else {
            $this->set('title', 'SETUP');
            $this->set('controller', $this->_controller);

            $this->_session->start();
            if ($success = $this->_session->getDelete('success')) $this->set('success', $success);
            if ($error = $this->_session->getDelete('error')) $this->set('error', $error);
            $this->_session->forget();

            $this->_template->render();
        }
    }

    private function gotologin($error = 'previous'){
        $this->_session->start();
        $this->_session->put('error',"Login to access $error page !");
        Router::go(array('users','login'));
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
                Router::go(array('mailsettings','viewall'));

            }
            else {
                $this->_session->start();
                $this->_session->put('error', 'Passwords must be identical');
                Router::go(array($this->_controller, 'setup'));
            }
        }
        else {
            $this->_session->start();
            $this->_session->put('error', "All fields are required");
            Router::go(array($this->_controller, 'setup'));
        }
    }
}