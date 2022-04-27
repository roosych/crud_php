<?php
include 'config.php';

$pdo = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DBNAME.'', MYSQL_USER, MYSQL_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
