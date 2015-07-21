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

    public function getDefault(){
        $query = "select id from mailsettings where def=1";
        if($result = $this->query($query,1)) return $result->id;
        else return 0;
    }

    public function setDefault($id){
        $id = $this->_mysqli->escape_string($id);
        $query = "update mailsettings set def=0";
        $ok = $this->query($query);
        $query = "update mailsettings set def=1
                  where id = $id";
        $ok =ok && $this->query($query);
        //var_dump($query);
        return $ok;
    }

    public function update($id,$json){
        $id = $this->_mysqli->escape_string($id);
        $query = "update mailsettings set smtp_config='$json'
                      where id=$id ";
        //var_dump($query);
        return $this->query($query);
    }

    public function delete($id){
        $id = $this->_mysqli->escape_string($id);
        $query = "delete from mailsettings where id = $id";
        return $this->query($query);
    }

    public function getAllSettings(){
        $query = "select * from mailsettings";
        return $this->query($query);
    }

    public function get(){
        if($id = $this->getDefault()) {
            $query="select smtp_config from mailsettings where id = $id";
            $result = $this->query($query,1);
        }
        else return null;

        if($this->_result->num_rows>=1){
            $cfg = json_decode($result->smtp_config);

            $mail = new PHPMailer;
            $obj = new Cript();

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->SMTPAuth = true;                               // Enable SMTP authentication

            $mail->Host = $cfg->host;  // Specify main and backup SMTP servers
            $mail->Port = $cfg->port;                                    // TCP port to connect to
            $mail->SMTPSecure = $cfg->stype;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Username = $cfg->email;                // SMTP username
            $mail->Password = $obj->decript($cfg->password);                           // SMTP password

            $mail->From = $mail->Username;
            $mail->FromName = 'Account Products_pilot';

            $mail->addReplyTo($mail->From, $mail->FromName);

            return $mail;
        }
        return null;
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