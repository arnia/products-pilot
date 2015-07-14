<?php

class User extends Model{
    private $id;
    private $email;
    private $password;
    private $hash;
    private $verified;

    public function __construct($params = NULL)
    {

        parent::__construct();

        if(isset($params['email'])){
            $this->email = $params['email'];
        }
        if(isset($params['password'])){
            $this->password = $params['password'];
        }
        if(isset($params['hash'])){
            $this->hash = $params['hash'];
        }
        if(isset($params['verified'])){
            $this->verified = $params['verified'];
        }
    }


    public function auth($email,$password,$checkbox = 0){
        $email = $this->_mysqli->escape_string($email);
        $password = md5($this->_mysqli->escape_string($password));

        $query="select id from users where email='$email' and password='$password' and verified=1;";

        if(!$this->query($query)) return "Incorrect email or password or database error";

        if($this->_result->num_rows==1) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if($checkbox == 1){
                setcookie("user_auth",$email,mktime()+(3600*24),"/");
            }
            else{
                $_SESSION['user_auth'] = $email;
            }

            $_SESSION['user_key'] = md5(rand(1,1000));

            return null;
        }
        else{
            $query="select verified from users where email='$email' and verified=0;";
            $result=$this->_mysqli->query($query);
            if($result->num_rows==1) {
                return "Email is not verified";
            }
            else{
                return "Incorrect email or password";
            }
        }
        return "Database Error";
    }

    public function add(){
        if(isset($this->email) && isset($this->password) && isset($this->hash)){

            $this->email = $this->_mysqli->real_escape_string($this->email);
            $this->password = md5($this->_mysqli->real_escape_string($this->password));

            $query="insert into users(email,password,hash) values ('$this->email','$this->password','$this->hash');";
            $result = $this->query($query);
            $this->id = $this->_mysqli->insert_id;
            return $result;
        }
        return null;
    }
    public function delete(){
        if(isset($this->id)){
            $query = "delete from users where id=" .$this->_mysqli->real_escape_string($this->id) ;
            return $this->query($query);
        }
        return null;
    }

    public function verify($email, $hash){
        $email=$this->_mysqli->escape_string($email);
        $hash=$this->_mysqli->escape_string($hash);

        $query="select id from users where email='$email' and hash='$hash' and verified=0;";

        if(!$this->query($query)) return 'The url is either invalid or you already have activated your account.';

        if($this->_result->num_rows==1) {
            $query="update users set verified=1 where email='$email' and hash='$hash' and verified=0;";
            if ($this->query($query)) return 'Your account has been activated';
            else return 'Error to verified';
        }
        else{
            return 'The url is either invalid or you already have activated your account.';
        }
    }

    public static function isAuth(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if((isset($_COOKIE['user_auth']) && !empty($_COOKIE['user_auth'])) || (isset($_SESSION['user_auth']) && !empty($_SESSION['user_auth'])) ) {
            return true;
        }
        return false;
    }
    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param mixed $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return mixed
     */
    public function getVerified()
    {
        return $this->verified;
    }

    /**
     * @param mixed $verified
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}