<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=tripdayaz_marlinphp', 'tripdayaz_admin', 'rusikkatv1');
}
catch (PDOException $e) {
    echo $e->getMessage();
}

$sql = 'SELECT * FROM images WHERE id = :id';
$statement = $pdo->prepare($sql);
$statement->execute(['id' => $_GET['id']]);
$image = $statement->fetch(PDO::FETCH_ASSOC);

$img = $image['image'];

//удаление физического файла
unlink('uploads/'.$img);

//удаление картинки с базы
$sql = "DELETE FROM images WHERE id = :id";
$statement = $pdo->prepare($sql);
$statement->execute($_GET);

header('Location: task_15_1.php');
var_dump($image);

