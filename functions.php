<?php

include 'config.php';

function getPeoples() {
    $pdo = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DBNAME.'', MYSQL_USER, MYSQL_PASS);
    $sql = 'SELECT * FROM peoples';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}