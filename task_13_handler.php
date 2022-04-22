<?php
session_start();

$_SESSION['counter'];
$_SESSION['counter']++;
header('Location: task_13.php');

