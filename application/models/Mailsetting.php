<?php

class Mailsetting extends Model{
    private $host;
    private $port;
    private $stype;
    private $email;
    private $password;

    public function __construct($params = NULL){

        parent:: __construct();

        if(isset($params['email'])){
            $this->email = $params['email'];
        }
        if(isset($params['password'])){
            $this->password = $params['password'];
        }
        if(isset($params['host'])){
            $this->hash = $params['host'];
        }
        if(isset($params['stype'])){
            $this->verified = $params['stype'];
        }
        if(isset($params['port'])){
            $this->verified = $params['port'];
        }
    }


    public function add($json){
        $query = "insert into mailsettings (smtp_config) values ('$json');";
        $this->query($query);
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param mixed $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return mixed
     */
    public function getStype()
    {
        return $this->stype;
    }

    /**
     * @param mixed $stype
     */
    public function setStype($stype)
    {
        $this->stype = $stype;
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