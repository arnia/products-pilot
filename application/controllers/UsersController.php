<?php

class UsersController extends Controller{

    public function login(){
        $this->set('controller',$this->_controller);
        $this->set('title','Login');

        if($success = $this->_session->getDelete('success')) $this->set('success',$success);
        if($error = $this->_session->getDelete('error')) $this->set('error',$error);

        $this->_template->render();
    }
    public function auth()
    {

        $error = '';

        if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (isset($_POST['checkbox'])) $checkbox = 1;
            else $checkbox = 0;

            $error = $this->User->auth($email, $password, $checkbox);

            if (!$error) {

                if ($checkbox == 1) {
                    setcookie("user_auth", $email, mktime() + (3600 * 24), "/sessions");
                } else {
                    $this->_session->forget();
                    $this->_session->start();

                    $this->_session->put('user.email', $email);
                }

                Router::go(array('products', 'viewall'));
            }
        } else {
            $error = "All fields are required";
        }

        $this->_session->put('error',$error);
        Router::go(array($this->_controller, 'login'));
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

    public function logout(){

        $this->_session->start();

        if($this->_session->isValid()){
            if($this->_session->get('user.email')) {
                $this->_session->forget();

                $this->_session->start();

                $this->_session->put('success',session_id());

                //var_dump($this->_session->get('success'));

                Router::go(array('users','login',session_id()));
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

    public function changepass(){
        //if($this->_session->isAuth()){
            $this->_session->start();
            var_dump($this->_session->get('success'));

            $this->set('title','Reset Password');
            $this->set('controller',$this->_controller);
            $this->_template->render();
        //}
        //else {
            //$this->_session->put('error','Error to authorization key');
           // Router::go(array('users','login'));
        //}
    }

    public function account_settings(){
        if($this->_session->isAuth()){
            $this->gotologin();
        }
        else{
            $this->set('title','Account Settings');
            $this->set('controller',$this->_controller);

            $this->_session->forget();
            var_dump($this->_session->start());
            $this->_session->put('success',session_id());
            var_dump($this->_session->get('success'));

            $this->_template->render();
        }
    }

    private function gotologin(){
        $this->_template = new Template($this->_controller,'gotologin');
        $this->set('title','GoToLogin');
        $this->set('controller',$this->_controller);
        $this->_template->render();
    }
}