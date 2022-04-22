<?php
session_start();
include 'config.php';

function register(){
    // Обрезаем пробелы в пришедших данных
    $email = str_replace(" ","", $_POST['email']);
    $password = str_replace(" ", "", $_POST['password']);

    if(isset($_POST['submit'])) {

        // Если поля емаил и пароль формы не пустые, дёргаем с базы юзера по емаилу
        if(!empty($email) and !empty($password)){

            $pdo = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DBNAME.'', MYSQL_USER, MYSQL_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $sql = 'SELECT * FROM users WHERE email = :email';
            $stm = $pdo->prepare($sql);
            $stm->execute(['email' => $email]);
            $user = $stm->fetch(PDO::FETCH_ASSOC);

            // Проверяем если $user пришел не пустой
            if(!empty($user)) {
                $msg = 'Пользователь с email-ом <strong>'.$email.'</strong> существует!';
                $_SESSION['danger'] = $msg;
                header('Location: task_11.php');
                exit();
            } else {
                // Если юзера с таким емейлом нет - добавляем в базу, хешируя пароль
                $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

                $pdo = new PDO('mysql:host='.MYSQL_SERVER.';dbname='.MYSQL_DBNAME.'', MYSQL_USER, MYSQL_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                $sql = 'INSERT INTO users (email, password) VALUES (:email, :password)';
                $stm = $pdo->prepare($sql);
                $stm->execute(['email' => $email, 'password' => $hashed_pass]);

                $msg = 'Пользователь <strong>'.$email.'</strong> добавлен!';
                $_SESSION['success'] = $msg;
                header('Location: task_11.php');
                exit();
            }
        } else {
            $msg = 'Поля не могут быть пустыми!';
            $_SESSION['danger'] = $msg;
            header('Location: task_11.php');
            exit();
        }
    }
}

register();