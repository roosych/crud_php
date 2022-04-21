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

// Task 9
function createTask() {
    $text = $_POST['text'];

    if(isset($_POST['submit']) && $text != '') {
        $pdo = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DBNAME.'', MYSQL_USER, MYSQL_PASS);
        $sql = 'INSERT INTO tasks (text) VALUES (:text)';
        $statement = $pdo->prepare($sql);
        $statement->execute(['text' => $text]);

        header('Location: task_9.php');
    }


}