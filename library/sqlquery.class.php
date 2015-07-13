<?php

class SQLQuery {
    protected $_mysqli;
    protected $_result;
    private static $emptyDB = true;

    /** Connects to database **/

    function connect($host, $user, $password, $db_name) {
        $this->_mysqli = new mysqli($host, $user, $password);
        if ($this->_mysqli != null) {
            if ($this->_mysqli->select_db($db_name)) {
                return 1;
            }
            else {
                return 0;
            }
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
            /*
            $result = array();
            $table = array();
            $field = array();
            $tempResults = array();
            $numOfFields = $this->_mysqli->field_count;
            for ($i = 0; $i < $numOfFields; ++$i) {
                array_push($table,$this->_result->fetch_field_direct($i)->table);
                array_push($field,$this->_result->fetch_field_direct($i)->name);
            }

            while ($row = $this->_result->fetch_row()) {
                for ($i = 0;$i < $numOfFields; ++$i) {
                    $table[$i] = trim(ucfirst($table[$i]),"s");
                    $tempResults[$table[$i]][$field[$i]] = $row[$i];
                }
                if ($singleResult == 1) {
                    $this->_result->free_result;
                    //$json = json_encode($tempResults);
                    return $tempResults;
                }
                array_push($result,$tempResults);
                var_dump($result);
            }
            $this->freeResult();
            //$json = json_encode($result);
            return $result;
            */
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

    private static function createDataBase($host, $user, $password, $db_name){

        if(self::$emptyDB){
            self::$emptyDB = false;
            $mysqli = new mysqli($host, $user, $password);
            $query="create database $db_name;";
            $mysqli->query($query);

            $mysqli->select_db($db_name);
            $mysqli->set_charset(CHAR_SET);


            $query="create table types(
            id int(10) primary key auto_increment,
             name varchar(256)
            );";

            $mysqli->query($query);

            $query="create table products(
            id int(10) primary key auto_increment,
            name varchar(256) not null,
            type_id int(1),
            price float(10,4) not null,
            file varchar(256),
            foreign key (type_id) REFERENCES Types(id)
            );";

            $mysqli->query($query);

            $types=array('Hardware','Software','Book','Movie');
            for($i=0;$i<4;$i++){
                $query="insert into types(name) values ('$types[$i]');";
                $mysqli->query($query) or die("error to insert types");
            }

            $query="create table users (
            id int(10) primary key auto_increment,
            email varchar(32) not null unique,
            password varchar(32) not null,
            hash varchar(32) not null,
            verified boolean default false not null
            )";

            $mysqli->query($query);


            $query="create table mailsettings(
            id int(10) primary key auto_increment,
            smtp_config mediumtext
            )";
            $mysqli->query($query);

        }

    }
}