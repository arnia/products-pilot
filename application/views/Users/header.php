<!DOCTYPE html>
<html lang="en">
<head>
    <title> <?php if(isset($title)) echo $title; else echo "Products" ?></title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo DOMAIN; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #main{
            margin:auto;
            margin-top: 200px;
            width: 10%;
        }
        #toright{
            margin-left:auto;
            margin-right: 0;
            width: 10%;
        }

    </style>
</head>
<body>
<div id="main">