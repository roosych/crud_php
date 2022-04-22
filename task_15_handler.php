<?php

$image = $_FILES['image'];

// проверка на наличие картинки в форме
if(!empty($image)) {
    // если картнка есть, генерим название файла и записываем в базу
    $pathinfo = pathinfo($image['name']);
    $tmp_name = $image['tmp_name'];
    $file_extension = $pathinfo['extension'];
    $filename = uniqid() . '.' . $file_extension;

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=tripdayaz_marlinphp', 'tripdayaz_admin', 'rusikkatv1');
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }

    $sql = 'INSERT INTO images (image) VALUES (:image)';
    $statement = $pdo->prepare($sql);
    $statement->execute(['image' => $filename]);

    // перемещение временного файла в папку "uploads"
    move_uploaded_file($tmp_name, 'uploads/' . $filename);
}

header('Location: task_15.php');