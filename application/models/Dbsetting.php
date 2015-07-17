<?php

class Dbsetting extends Model{

    public function install($db_name,$email,$pass){


        $this->connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


        $this->_mysqli->query("create database if not exists $db_name");
        $this->_mysqli->select_db($db_name);
        $this->_mysqli->set_charset(CHAR_SET);

        $this->_mysqli->query("
            create table if not exists mailsettings(
                id int(10) primary key auto_increment,
                smtp_config mediumtext
            );");

        $result = $this->_mysqli->query("
            create table types(
                id int(10) primary key auto_increment,
                 name varchar(256)
            )
            ");
        if($result) $this->_mysqli->query("insert into types(name) values ('Hardware'),('Software'),('Book'),('Movie')");


        $this->_mysqli->query("
            create table if not exists products(
                id int(10) primary key auto_increment,
                name varchar(256) not null,
                type_id int(1),
                price float(10,4) not null,
                file varchar(256),
                foreign key (type_id) REFERENCES Types(id)
            );
        ");

        $result = $this->_mysqli->query("
            create table users (
                id int(10) primary key auto_increment,
                email varchar(32) not null unique,
                password varchar(32) not null,
                hash varchar(32) not null,
                verified boolean default false not null
            );
        ");

        $email = $this->_mysqli->escape_string($email);
        $pass = md5($this->_mysqli->escape_string($pass));

        if($result) $this->_mysqli->query("insert into users values (1,'$email','$pass','superuser',1)");

        $result = $this->_mysqli->query("
        create table if not exists admins (
            id int(10) primary key auto_increment,
            user_id int(10) unique not null,
            foreign key (user_id) references users(id)
            on delete cascade
            on update cascade
        );
        ");
        if($result) $this->_mysqli->query("insert into admins(user_id) values (1);");
    }
}