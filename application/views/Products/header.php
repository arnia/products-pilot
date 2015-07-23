<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <title> <?php if(isset($title)) echo $title; else echo "Products" ?></title>

    <style>
        #main{
            margin:auto;
            margin-top: 30px;
            width: 70%;
        }
        #toright{
            margin-left:auto;
            margin-right: 0;
            width:7%;
        }
        #cart_logo{
            width:25px;
        }

        .products{
            margin-top:30px;
            float:left;
        }

    </style>
</head>
<body onload="countCart('<?php if(isset($email)) echo $email ?>')">

<div id="main">
