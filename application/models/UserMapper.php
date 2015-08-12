<?php

class Application_Model_UserMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_User');
        }
        return $this->_dbTable;
    }

    public function insert(Application_Model_User $user){
        $data = array(
            'email'     => $user->email,
            'password'  => $user->password,
            'hash'      => $user->hash,
        );
        return $this->getDbTable()->insert($data);
    }

    public function verify($email, $hash)
    {

        $result = $this->getDbTable()->fetchRow($this->getDbTable()->select('id')
                                                                    ->where('email = ?', $email)
                                                                    ->where('hash = ?', $hash)
                                                                    ->where('verified =?', 0));
        if(count($result) == 1){
            if($this->getDbTable()->update(
                    array(
                        'verified' => 1
                    ),
                    array(
                        'email = ?' => $email
                    )
                )
            ) return true;
        }
        return false;
    }

    public function delete(Application_Model_User $user){

        return $this->getDbTable()->delete(array('email = ?' => $user->email));
    }








    public function updatecart($email,$product_id,$nr){
        $email = $this->_mysqli->real_escape_string($email);
        $product_id = $this->_mysqli->real_escape_string($product_id);
        $query = "select id from users where email = '$email'";
        $user_id = $this->query($query,1)->id;

        $this->query("delete from shoppingcarts where user_id = $user_id && product_id = $product_id");

        for($i = 0;$i < $nr;$i++){
            $this->query("insert into shoppingcarts values ($user_id, $product_id)");
        }
    }

    public function delFromCart($product_id){
        $product_id = $this->_mysqli->real_escape_string($product_id);
        $query = "delete from shoppingcarts where product_id = $product_id";
        if($this->query($query)) return null;
        return 'Database Error';
    }

    public function getShoppingCart($email){
        $email = $this->_mysqli->real_escape_string($email);
        $query = "select id from users where email = '$email'";
        $user_id = $this->query($query,1)->id;

        $query = "select p.id, p.name name, t.name type, p.price, shcart.nr from products p
                  join types t on (t.id = p.type_id)
                  join (
                          select p.id, count(1) nr from products p
                          join shoppingcarts s on (s.product_id = p.id)
                          join users u on (u.id = s.user_id)
                          where s.user_id = $user_id
                          group by p.id
                        ) shcart on (shcart.id = p.id)";
        return $this->query($query);
    }

    public function umkAdmin($admin_id){
        $admin_id = $this->_mysqli->real_escape_string($admin_id);
        $query = "delete from admins where id = $admin_id";
        if($this->query($query)) return null;
        return 'Database Error';
    }

    public function mkAdmin($user_id){
        $query = "insert into admins(user_id) values ('$user_id')";
        if($this->query($query)) return null;
        return 'Database Error';
    }

    public function getAllUsers(){
        $query = "SELECT u.id id, u.email email, u.verified verified, a.id admin_id FROM users u
                  left join admins a on(u.id = a.user_id);";
        return $this->query($query);
    }

    public function isAdmin($email){
        $email = $this->_mysqli->escape_string($email);
        $query = "select email from users u
                  join admins a on (a.user_id = u.id)
                  where email = '$email'
                  ";
        $result = $this->query($query);
        if($result) return true;
        return false;
    }

    public function auth($email,$password){
        $email = $this->_mysqli->escape_string($email);
        $password = md5($this->_mysqli->escape_string($password));

        $query="select id from users where email='$email' and password='$password' and verified=1;";

        $this->query($query);

        //var_dump($this->_result);

        if($this->_result->num_rows==1) {
            var_dump('dsad');
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
        return "Incorrect email or password";
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

    public function rpass(){
        $this->email = $this->_mysqli->escape_string($this->email);
        $query="select password from users where email='$this->email'";

        $result = $this->query($query,1);
        if ($result) $this->password = $result->password;

        if($this->_result->num_rows == 1) {
            $length = 8;
            $pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
            $m_pass = md5($pass);
            $query = "update users
                      set password = '$m_pass'
                      where email = '$this->email'";

            if($this->query($query)) return $pass;
            return null;
        }
    }

    public function oldpass(){
        $this->email=$this->_mysqli->escape_string($this->email);
        $query = "update users
                set password = '$this->password'
                where email = '$this->email'";
        return $this->_mysqli->query($query);
    }

    public function cpass($oldpassword){

        $this->email = $this->_mysqli->escape_string($this->email);
        $this->password = md5($this->_mysqli->escape_string($this->password));
        $oldpassword = md5($this->_mysqli->escape_string($oldpassword));

        $query="select id from users where email = '$this->email' and password = '$oldpassword'";

        $result = $this->query($query,1);
        if (!$result) return false;

        $query = "update users set password='$this->password' where email = '$this->email' and password = '$oldpassword'";

        return $this->query($query);
    }

}