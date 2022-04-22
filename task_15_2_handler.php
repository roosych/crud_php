<?php

$image_name = $_FILES['image']['name'];
$tmp_name = $_FILES['image']['tmp_name'];

// проверка на наличие картинки в форме
if(!empty($_FILES['image']['name'][0])) {
    for ($i = 0; $i < count($image_name); $i++) {
        upload_image($image_name[$i], $tmp_name[$i]);
    }
}

function upload_image($filename, $tmp_name){
    $result = pathinfo($filename);
    $filename = uniqid() . '.' . $result['extension'];

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=tripdayaz_marlinphp', 'tripdayaz_admin', 'rusikkatv1');
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }

    $sql = 'INSERT INTO images (image) VALUES (:image)';
    $statement = $pdo->prepare($sql);
    $statement->execute(['image' => $filename]);

    //перемещение временного файла в папку "uploads"
    move_uploaded_file($tmp_name, 'uploads/' . $filename);
}

header('Location: task_15_2.php');