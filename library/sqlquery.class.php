<?php

class SQLQuery {
    protected $_mysqli;
    protected $_result;
    private static $emptyDB = true;

    /** Connects to database **/

    function connect($host, $user, $password, $db_name) {

        $this->_mysqli = new mysqli($host, $user, $password);

        if ($this->_mysqli != null) {
            $this->_mysqli->select_db($db_name);
            return 1;
        }
        else {
            return 0;
        }
    }

    /** Disconnects from database **/

    function disconnect() {
        if ($this->_mysqli->close()) {
            return 1;
        }  else {
            return 0;
        }
    }

    function selectAll() {
        $query = 'select * from `'.$this->_table.'`';
        return $this->query($query);
    }

    function select($id) {
        $query = 'select * from `'.$this->_table.'` where `id` = \''.$this->_mysqli->real_escape_string($id).'\'';
        return $this->query($query, 1);
    }


    /** Custom SQL Query **/

    function query($query, $singleResult = 0) {

        $this->_result = $this->_mysqli->query($query); //Execute query
        //var_dump($this->_mysqli->error_list);
        if (preg_match("/select/i",$query) && $this->_result ) {

            $result = array();
            $i= 0;

            if($singleResult) {
                $result = $this->_result->fetch_object();
                return $result;
            }

            while($product = $this->_result->fetch_object()){
                $result[$i++]=$product;
            }
            return $result;
        }
        return $this->_result;
    }


    /** Get error string **/

    function getError() {
        return $this->_mysqli->error;
    }
}