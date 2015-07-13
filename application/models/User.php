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


    public function auth($email,$password){
        $email=$this->_mysqli->escape_string($_POST['email']);
        $password=$this->_mysqli->escape_string(md5($_POST['password']));

        $query="select id,verified from users where email='$email' and password='$password' and verified=1;";
        $this->query($query);

        if($this->_result->num_rows==1) {
            if(isset($_POST['checkbox']) && !empty($_POST['checkbox']) && $_POST['checkbox']==1){
                setcookie("user_auth",$email,mktime()+(3600*24),"/");
            }
            else{
                session_start();
                $_SESSION['user_auth'] = $email;
            }
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