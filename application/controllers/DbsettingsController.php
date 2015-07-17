<?php

class DbsettingsController extends Controller{

    public function index(){
        $this->set('title','Database Settings');

        $this->set('controller',$this->_controller);

        $this->_session->start();
        if($success = $this->_session->getDelete('success')) $this->set('success',$success);
        if($error = $this->_session->getDelete('error')) $this->set('error',$error);

        $this->_template->render();
    }

    public function install(){
        if( isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2']) &&
            isset($_POST['db_host']) && isset($_POST['db_name']) && isset($_POST['db_password']) && isset($_POST['db_user'])) {

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $this->_session->start();
                $this->_session->put('error', 'Invalid email format');
                Router::go(array($this->_controller, 'index'));
            }

            $pass = $_POST['password1'];

            if (($_POST['password1'] == $_POST['password2'])
                && (preg_match("/([A-Z]+[a-z]+[0-9]+)|([A-Z]+[0-9]+[a-z]+)|([a-z]+[A-Z]+[0-9]+)|([a-z]+[0-9]+[A-Z]+)|([0-9]+[A-Z]+[a-z]+)|([0-9]+[a-z]+[A-Z]+)/", $pass))
                && (preg_match("/^.{8,}$/", $pass)))
            {
                $db_host = $_POST['db_host'];
                $db_user = $_POST['db_user'];
                $db_name = $_POST['db_name'];
                $db_password = $_POST['db_password'];
                $email = $_POST['email'];

                $conf = fopen(ROOT . DS . 'config' . DS . 'config.php', 'w');
                fwrite($conf,
                    "
                     <?php
                     //database constants
                     define ('DEVELOPMENT_ENVIRONMENT',true);
                     define('DB_NAME', '$db_name');
                     define('DB_USER', '$db_user');
                     define('DB_PASSWORD', '$db_password');
                     define('DB_HOST', '$db_host');
                     define('CHAR_SET', 'utf8');
                     ");
                fclose($conf);
                try{
                    $this->Dbsetting->install($db_name,$email,$pass);
                }
                catch (mysqli_sql_exception $e) {
                    $this->_session->start();
                    $this->_session->put('error','Please try again with valid database fields');
                    Router::go(array('dbsettings','index'));
                }

                $this->_session->start();
                $this->_session->put('success','Database was initialized');
                Router::go(array('users','login'));

            }
            else {
                $this->_session->start();
                $this->_session->put('error','Invalid password (required minimum:8 characters, 1 uppercase, 1 lowercase, 1 numeric)');
                Router::go(array($this->_controller, 'index'));
            }
        }
        else {
            $this->_session->start();
            $this->_session->put('error','All fields are required');
            Router::go(array($this->_controller, 'index'));
        }
    }
}