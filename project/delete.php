<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=tripdayaz_marlinphp', 'tripdayaz_admin', 'rusikkatv1');
}
catch (PDOException $e) {
    echo $e->getMessage();
}
$sql = "SELECT * FROM users WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->execute($_GET);
$user = $statement->fetch(PDO::FETCH_ASSOC);


$id = $_GET['id'];
$filename = $user['image'];


function delete_user($id, $filename) {
    $pdo = new PDO('mysql:host=localhost;dbname=tripdayaz_marlinphp', 'tripdayaz_admin', 'rusikkatv1');

    //удаление физического файла
    unlink('uploads/'.$filename);

    //удаление пользотвателя с базы
    $sql = "DELETE FROM users WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute($_GET);
}

delete_user($id, $filename);

header('Location: index.php');