<?php
session_start();

$text = $_POST['text'];

$_SESSION['message'] = $text;
header('Location: task_12.php');
exit();