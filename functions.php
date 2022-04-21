<?php
session_start();
include 'config.php';

function getPeoples() {
    $pdo = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DBNAME.'', MYSQL_USER, MYSQL_PASS);
    $sql = 'SELECT * FROM peoples';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

// Task 9 + Task 10
function createTask() {

    if(isset($_POST['submit'])) {
        $text = $_POST['text'];

        $pdo = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DBNAME.'', MYSQL_USER, MYSQL_PASS);
        $sql = 'SELECT * FROM tasks WHERE text = :text';
        $statement = $pdo->prepare($sql);
        $statement->execute(['text' => $text]);
        $task = $statement->fetch(PDO::FETCH_ASSOC);

        if(!empty($task)) {
            $msg = 'Такая задача существует!';
            $_SESSION['danger'] = $msg;
        } else {
            $pdo = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DBNAME.'', MYSQL_USER, MYSQL_PASS);
            $sql = 'INSERT INTO tasks (text) VALUES (:text)';
            $statement = $pdo->prepare($sql);
            $statement->execute(['text' => $text]);

            $msg = 'Задача <strong>"'.$text.'"</strong> создана!';
            $_SESSION['success'] = $msg;
        }

    }
}
createTask();

