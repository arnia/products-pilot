<?php

class UsersController extends Controller{

    public function login($error = NULL){
        $this->set('controller',$this->_controller);
        $this->set('title','Login');
        $this->set('error',$error);
        if(isset($_GET['succes'])) $this->set('succes',$_GET['succes']);

        $this->_template->render();
    }
    public function auth(){

        $error = '';

        if(isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])){
            $email = $_POST['email'];
            $password = $_POST['password'];

            if(isset($_POST['checkbox'])) $checkbox = 1;
            else $checkbox = 0;

            $error = $this->User->auth($email,$password,$checkbox);

            if(!$error){

                $path = Router::buildPath(array('products','viewall'));
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
        if(isset($_POST['email']) && !empty($_POST['email']) &&
            isset($_POST['password1']) && !empty($_POST['password1']) &&
            isset($_POST['password2']) && !empty($_POST['password2'])){

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $path = Router::buildPath(array($this->_controller,'signup','Invalid email format'));
                header("Location:" . $path);
                exit();
            }

            $pass=$_POST['password1'];
            if(($_POST['password1']==$_POST['password2'])
                && (preg_match("/([A-Z]+[a-z]+[0-9]+)|([A-Z]+[0-9]+[a-z]+)|([a-z]+[A-Z]+[0-9]+)|([a-z]+[0-9]+[A-Z]+)|([0-9]+[A-Z]+[a-z]+)|([0-9]+[a-z]+[A-Z]+)/",$pass))
                && (preg_match("/^.{8,}$/",$pass)))
            {
                $this->User->setEmail($_POST['email']);
                $this->User->setPassword($_POST['password1']);
                $this->User->setHash(md5(rand(1,1000)));

                if ($this->User->add()) {
                    $setting = new Mailsetting();
                    $mail = $setting->get();

                    if($mail){

                        $subject = 'Signup | Verification';
                        $message = "<p>
                                    Thanks for signing up!
                                    Your account has been created, activate your account by pressing the url below.</p>
                                    <p>-----------------------</p>
                                    <p><a href='http://localhost/". DOMAIN ."/users/verify?email=" . $this->User->getEmail() ."&hash=" .$this->User->getHash() . "'>Click Here</a> to activate your account</p>";

                        //$send = mail($email, $subject, $message, $headers) or die("Error to send mail");
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->addAddress($this->User->getEmail());
                        $mail->Subject = $subject;
                        $mail->Body = $message;
                        $mail->AltBody = $message;
                        if($mail->send()){
                            $path = Router::buildPath(array($this->_controller,'login?succes=Your account has been made please verify it by clicking the activation link that has been send to your email.'));
                            header("Location:" . $path);
                            exit();
                        }
                        else{
                            $this->User->delete();
                            $path = Router::buildPath(array($this->_controller,'signup','Email could not be sent'));
                            header("Location:" . $path);
                            exit();
                        }
                    }
                    else{
                        $this->User->delete();
                        $path = Router::buildPath(array($this->_controller,'signup','Mailsettings is not setup'));
                        header("Location:" . $path);
                        exit();
                    }
                }
                else{
                    $path = Router::buildPath(array($this->_controller,'signup','Email already exist or other database error'));
                    header("Location:" . $path);
                    exit();
                }

            }
            else {
                $path = Router::buildPath(array($this->_controller,'signup','Invalid password (required minimum:8 characters, 1 uppercase, 1 lowercase, 1 numeric)'));
                header("Location:" . $path);
                exit();
            }
        }
        else {
            $path = Router::buildPath(array($this->_controller,'signup','All fields are required'));
            header("Location:" . $path);
            exit();
        }
    }

    public function verify(){
        if(isset($_GET['email']) && isset($_GET['hash'])){
            $message = $this->User->verify($_GET['email'], $_GET['hash']);
            $path = Router::buildPath(array($this->_controller,"login?succes=$message"));
            header("Location:" . $path);
            exit();
        }
        else {
            $path = Router::buildPath(array($this->_controller,'signup','The url is either invalid or you already have activated your account.'));
            header("Location:" . $path);
            exit();
        }
    }

    public function logout($user_key = null){
        if($this->auth_key($user_key) and $user_key){
            if((isset($_COOKIE['user_auth']) && !empty($_COOKIE['user_auth'])) || (isset($_SESSION['user_auth']) && !empty($_SESSION['user_auth'])) ) {
                if((isset($_COOKIE['user_auth']) && !empty($_COOKIE['user_auth']))){
                    setcookie("user_auth",null,mktime()-3600,"/");
                }
                elseif (isset($_SESSION['user_auth']) && !empty($_SESSION['user_auth'])){
                    session_destroy();
                }
                Router::go(array('users','login?succes=LogOut Successfully'));
            }
            else Router::go(array('users','login','You are already logged out'));
        }
        else Router::go(array('users','login','Error to authorization key'));
    }

    public function resetpass(){
        $this->set('title','Reset Password');
        $this->set('controller',$this->_controller);
        $this->_template->render();
    }

    public function changepass($user_key){
        if($this->auth_key($user_key) and !$user_key){
            $this->set('title','Reset Password');
            $this->set('controller',$this->_controller);
            $this->_template->render();
        }
        else Router::go(array('users','login','Error to authorization key'));
    }

    public function account_settings(){
        if(!User::isAuth()){
            $this->gotologin();
        }
        else{
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $this->set('title','Account Settings');
            $this->set('controller',$this->_controller);
            if(isset($_SESSION['user_key'])) $this->set('user_key',$_SESSION['user_key']);

            $this->_template->render();
        }
    }

    public function auth_key($user_key){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user_key']) && $_SESSION['user_key'] == $user_key) return true;
        return false;
    }
    private function gotologin(){
        $this->_template = new Template($this->_controller,'gotologin');
        $this->set('title','GoToLogin');
        $this->set('controller',$this->_controller);
        $this->_template->render();
    }
}