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
            margin-top: 50px;
            width: 15%;
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