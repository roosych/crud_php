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


// переменные с формы
$id = $_POST['id'];
$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];
$status = $_POST['status'];
$image = $_FILES['image']['name'][0];

function update_user($id, $login, $email, $password, $role, $status) {
    // подключение к базе
    $pdo = new PDO('mysql:host=localhost;dbname=tripdayaz_marlinphp', 'tripdayaz_admin', 'rusikkatv1');

    // хэширование пароля
    if(!$_POST['password'] == '') {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    // id - название столбца, :id(плейсхолдер, метка) - ключ данных в массиве, который уходит в базу
    $sql = "UPDATE users SET id=:id, login=:login, email=:email, password=:password, role=:role, status=:status WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $data = [
        'id' => $id,
        'login' => $login,
        'email' => $email,
        'password' => $hashed_password,
        'role' => $role,
        'status' => $status,
    ];
    $statement->execute($data);
}

function update_avatar($id, $image) {
    $pdo = new PDO('mysql:host=localhost;dbname=tripdayaz_marlinphp', 'tripdayaz_admin', 'rusikkatv1');

    //генерим название файла и записываем в базу
    $image = pathinfo($_FILES['image']['name']);
    $tmp_name = $_FILES['image']['tmp_name'];
    $file_extension = $image['extension'];
    $filename = uniqid() . '.' . $file_extension;

    //перемещение временного файла в папку "uploads"
    move_uploaded_file($tmp_name, 'uploads/' . $filename);

    // id - название столбца, :id(плейсхолдер, метка) - ключ данных в массиве, который уходит в базу
    $sql = "UPDATE users SET id=:id, image=:image WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $data = [
        'id' => $id,
        'image' => $filename,
    ];
    $statement->execute($data);

}


if(isset($_POST['submit'])) {
    // если форма отправлена - запись полученных данных в базу
    update_user($id, $login, $email, $password, $role, $status);

    // если поле с картинкой не пустое - сохранение аватарки пользователя по id
    if(!empty($image)) {
        update_avatar($id, $image);
    }

    // перенаправление
    header('Location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title>
            Подготовительные задания к курсу
        </title>
        <meta name="description" content="Chartist.html">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
        <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
        <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
        <link rel="stylesheet" media="screen, print" href="css/statistics/chartist/chartist.css">
        <link rel="stylesheet" media="screen, print" href="css/miscellaneous/lightgallery/lightgallery.bundle.css">
        <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
        <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
        <link rel="stylesheet" media="screen, print" href="css/fa-regular.css">
    </head>
    <body class="mod-bg-1 mod-nav-link ">
        <main id="js-page-content" role="main" class="page-content">
            <div class="col-md-8">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            Задание
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                            <h5 class="frame-heading">
                                Редактирование пользователя
                            </h5>
                            <div class="frame-wrap">
                                <form action="edit.php?id=<?=$user['id']?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" value="<?=$user['id']?>" name="id">
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Логин</label>
                                        <input type="text" id="simpleinput" class="form-control" value="<?=$user['login']?>" name="login">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="example-email-2">Email</label>
                                        <input type="email" id="example-email-2" name="email" class="form-control" placeholder="Email" value="<?=$user['email']?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="example-password">Password</label>
                                        <input type="password" id="example-password" class="form-control" value="" name="password">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="example-select">Роль</label>
                                        <select class="form-control" id="example-select" name="role">
                                            <option value="1">Обычный пользователь</option>
                                            <option value="2">Контент-менеджер</option>
                                            <option value="3">Администратор</option>
                                        </select>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="flexRadioDefault1" value="1" name="status" checked>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Активен
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="flexRadioDefault2" value="0" name="status">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Забанен
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="example-fileinput">Аватар</label>
                                        <input type="file" id="example-fileinput" class="form-control-file" name="image">



                                        <img src="<?php

                                        if($user['image'] == '') {
                                            //echo 'uploads/'.$user['image'];
                                            echo 'img/demo/avatars/avatar-m.png';
                                        } else {
                                            echo 'uploads/'.$user['image'];
                                        }

                                        ?>" width="100">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-warning" name="submit">Изменить</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        

        <script src="js/vendors.bundle.js"></script>
        <script src="js/app.bundle.js"></script>
        <script>
            // default list filter
            initApp.listFilter($('#js_default_list'), $('#js_default_list_filter'));
            // custom response message
            initApp.listFilter($('#js-list-msg'), $('#js-list-msg-filter'));
        </script>
    </body>
</html>
