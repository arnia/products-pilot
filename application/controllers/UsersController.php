<?php

class UsersController extends Controller{

    public function login(){
        $this->set('controller',$this->_controller);
        $this->set('title','Login');

        $this->_session->start();
        if($success = $this->_session->getDelete('success')) $this->set('success',$success);
        if($error = $this->_session->getDelete('error')) $this->set('error',$error);
        $this->_session->forget();

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

                    $this->_session->putc('user_email',$email);

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
        $this->_session->start();
        $this->_session->put('error',$error);
        Router::go(array($this->_controller, 'login'));
    }

    public function signup(){
        $this->set('title','SignUp');
        $this->set('controller',$this->_controller);
        $this->_session->start();

        if($success = $this->_session->getDelete('success')) $this->set('success',$success);
        if($error = $this->_session->getDelete('error')) $this->set('error',$error);

        $this->_template->render();
    }

    public function signupadd(){
        if(isset($_POST['email']) && !empty($_POST['email']) &&
            isset($_POST['password1']) && !empty($_POST['password1']) &&
            isset($_POST['password2']) && !empty($_POST['password2'])){

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $this->_session->start();
                $this->_session->put('error','Invalid email format');
                Router::go(array($this->_controller,'signup'));
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
                            $this->_session->start();
                            $this->_session->put('success','Your account has been made please verify it by clicking the activation link that has been send to your email.');
                            Router::go(array($this->_controller,'login'));
                        }
                        else{
                            $this->User->delete();
                            $this->_session->start();
                            $this->_session->put('error','Email could not be sent');
                            Router::go(array($this->_controller,'signup'));
                        }
                    }
                    else {
                        $this->User->delete();
                        $this->_session->start();
                        $this->_session->put('error', 'Mailsettings is not setup');
                        Router::go(array($this->_controller, 'signup'));
                    }
                }
                else{
                    $this->_session->start();
                    $this->_session->put('error','Email already exist or other database error');
                    Router::go(array($this->_controller, 'signup'));
                }
            }
            else {
                $this->_session->start();
                $this->_session->put('error','Invalid password (required minimum:8 characters, 1 uppercase, 1 lowercase, 1 numeric)');
                Router::go(array($this->_controller, 'signup'));
            }
        }
        else {
            $this->_session->start();
            $this->_session->put('error','All fields are required');
            Router::go(array($this->_controller, 'signup'));
        }
    }

    public function verify(){
        if(isset($_GET['email']) && isset($_GET['hash'])){
            $message = $this->User->verify($_GET['email'], $_GET['hash']);
            $this->_session->start();
            $this->_session->put('success',$message);
            Router::go(array($this->_controller,"login"));
        }
        else {
            $this->_session->start();
            $this->_session->put('success','The url is either invalid or you already have activated your account.');
            Router::go(array($this->_controller,'signup'));
        }
    }

    public function logout(){

        $this->_session->start();

        if($this->_session->isValid()){
            if($this->_session->get('user.email')) {

                $this->_session->forget();
                $this->_session->start();
                $this->_session->put('success','You are now logged out');
                //var_dump($this->_session->get('success'));
                Router::go(array('users','login'));
            }
            elseif($this->_session->getc('user_email')){

                $this->_session->distroyc('user_email');
                $this->_session->start();
                $this->_session->put('success','You are now logged out');
                Router::go(array('users','login'));
            }
            else {
                $this->_session->start();
                $this->_session->put('error','You are already logged out');
                Router::go(array('users','login'));
            }
        }
        elseif($this->_session->getc('user_email')){

            $this->_session->distroyc('user_email');
            $this->_session->start();
            $this->_session->put('success','You are now logged out');
            Router::go(array('users','login'));
        }
        else {
            $this->_session->start();
            $this->_session->put('error','You are already logged out');
            Router::go(array('users','login'));
        }
    }

    public function resetpass(){
        $this->set('title','Reset Password');
        $this->set('controller',$this->_controller);

        $this->_session->start();
        if($success = $this->_session->getDelete('success')) $this->set('success',$success);
        if($error = $this->_session->getDelete('error')) $this->set('error',$error);
        $this->_session->forget();

        $this->_template->render();
    }

    public function changepass(){
        if($this->_session->isAuth()){
            $this->set('title','Change Password');
            $this->set('controller',$this->_controller);

            $this->_session->start();
            if($success = $this->_session->getDelete('success')) $this->set('success',$success);
            if($error = $this->_session->getDelete('error')) $this->set('error',$error);

            $this->_template->render();
        }
        else {
            $this->gotologin();
        }
    }

    public function account_settings(){
        if(!$this->_session->isAuth()){
            $this->gotologin();
        }
        else{
            $this->set('title','Account Settings');
            $this->set('controller',$this->_controller);

            $this->_template->render();
        }
    }

    private function gotologin($error = 'previous'){
        $this->_session->start();
        $this->_session->put('error',"Login to access $error page !");
        Router::go(array('users','login'));
    }

    public function rpass(){
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email=$_POST['email'];
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $this->_session->start();
                $this->_session->put('error','Invalid email format');
                Router::go(array($this->_controller,'resetpass'));
            }

            $this->User->setEmail($email);

            if($pass = $this->User->rpass($email)){
                $setting = new Mailsetting();
                $mail = $setting->get();

                if($mail){
                    $subject = "New Password";
                    $message = "<p>
                    New Password for $email is: $pass</p>
                    <p>-----------</p>
                    <a href='http://localhost/". Router::buildPath(array($this->_controller,'login')) ."'> Click Here </a> to login.";

                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->addAddress($email);
                    $mail->Subject = $subject;
                    $mail->Body = $message;
                    $mail->AltBody = $message;
                    if($mail->send()){
                        $this->_session->start();
                        $this->_session->put('success','Password has been changed, please verify your email.');
                        Router::go(array($this->_controller,'login'));
                    }
                    else{
                        $this->User->oldpass();
                        $this->_session->start();
                        $this->_session->put('error','Email could not be sent');
                        Router::go(array($this->_controller,'resetpass'));
                    }
                }
                else{
                    $this->User->oldpass();
                    $this->_session->start();
                    $this->_session->put('error','Mailsettings is not setup');
                    Router::go(array($this->_controller,'resetpass'));
                }
            }
            else{
                $this->_session->start();
                $this->_session->put('error','Email already exist or other database error');
                Router::go(array($this->_controller, 'resetpass'));
            }
        }
        else {
            $this->_session->start();
            $this->_session->put('error','Field required');
            Router::go(array($this->_controller, 'resetpass'));
        }

    }

    public function cpass()
    {
        if (!$this->_session->isAuth()) {
            $this->gotologin();
        } else {
            if (isset($_POST['password1']) && !empty($_POST['password1']) &&
                isset($_POST['password2']) && !empty($_POST['password2']) && isset($_POST['oldpassword']) && !empty($_POST['oldpassword'])
            ) {
                $this->User->setPassword($_POST['password1']);

                if (($_POST['password1'] == $_POST['password2'])
                    && (preg_match("/([A-Z]+[a-z]+[0-9]+)|([A-Z]+[0-9]+[a-z]+)|([a-z]+[A-Z]+[0-9]+)|([a-z]+[0-9]+[A-Z]+)|([0-9]+[A-Z]+[a-z]+)|([0-9]+[a-z]+[A-Z]+)/", $this->User->getPassword()))
                    && (preg_match("/^.{8,}$/", $this->User->getPassword()))
                ) {

                    $this->User->setPassword($_POST['password1']);
                    if($this->_session->get('user.email')) $this->User->setEmail($this->_session->get('user.email'));
                    if($this->_session->getc('user_email')) $this->User->setEmail($this->_session->getc('user_email'));

                    if($this->User->cpass($_POST['oldpassword'])) {
                        $this->_session->start();
                        $this->_session->put('success', 'Password changed');
                        Router::go(array($this->_controller, 'login'));
                    }
                    else{
                        $this->_session->start();
                        $this->_session->put('error', 'Old Passwords Is Wrong !');
                        Router::go(array($this->_controller, 'changepass'));
                    }
                } else {
                    $this->_session->start();
                    $this->_session->put('error', 'Invalid password (required minimum:8 characters, 1 uppercase, 1 lowercase, 1 numeric)');
                    Router::go(array($this->_controller, 'changepass'));
                }
            } else {
                $this->_session->start();
                $this->_session->put('error', 'All fields are required !');
                Router::go(array($this->_controller, 'changepass'));
            }
        }
    }
}