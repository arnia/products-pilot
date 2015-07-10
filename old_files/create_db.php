<?php

    $host="localhost";
    $user="root";
    $pass="ionut037";
    $db="db1";

    $mysqli=new mysqli($host,$user,$pass);
    if (mysqli_connect_errno()) {

        die("Unable to connect!");

    }

    $query="create database $db;";
    $result = $mysqli->query($query);
    if (mysqli_connect_errno()) {

        die("Unable to create database!");

    }


    $mysqli->select_db($db) or die ("Unable to select database!");


    $query="create table type(
    id int(10) primary key auto_increment,
    name varchar(256)
    );";
    $result = $mysqli->query($query);
    if (mysqli_connect_errno()) {

        die("Error to create table");

    }
    $query="create table product(
    id int(10) primary key auto_increment,
    name varchar(256) not null,
    type_id int(1),
    price float(10,4) not null,
    file varchar(256),
    foreign key (type_id) REFERENCES Type(id)
    );";
    $result = $mysqli->query($query);
    if (mysqli_connect_errno()) {

        die("Error to create table");

    }
    $types=array('Hardware','Software','Book','Movie');
    for($i=0;$i<4;$i++){
        $query="insert into type(name) values ('$types[$i]');";
        $mysqli->query($query) or die("error to insert types");
    }

    $query="create table user (
        id int(10) primary key auto_increment,
        email varchar(32) not null unique,
        password varchar(32) not null,
        hash varchar(32) not null,
        verified boolean default false not null
    )";
    $result = $mysqli->query($query);
    if (mysqli_connect_errno()) {
        die("Error to create table");
    }

    $query="create table mailsetting(
        id int(10) primary key auto_increment,
        smtp_config mediumtext
    )";
    $result = $mysqli->query($query);
    if (mysqli_connect_errno()) {

        die("Error to create table");

    }


    $mysqli->close();
    echo "succes";
    header('Location:/product_crud');
    exit();