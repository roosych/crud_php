<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=tripdayaz_marlinphp', 'tripdayaz_admin', 'rusikkatv1');
}
catch (PDOException $e) {
    echo $e->getMessage();
}

$user_id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id = $user_id";
$statement = $pdo->prepare($sql);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);


if($user['image'] == null) {
    $avatar = 'img/demo/avatars/avatar-m.png';
} else {
    $avatar = 'uploads/' . $user['image'];
}

switch($user['role']) {
    case 3:
        $role = 'Администратор';
        break;
    case 2:
        $role = 'Контент-менеджер';
        break;
    default:
        $role = 'Обычный пользователь';
        break;
}

switch($user['status']) {
    case 0:
        $status = '<span class="text-danger">Забанен</span>';
        break;
    case 1:
        $status = '<span class="text-success">Активен</span>';
        break;
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
                                Обычная таблица
                            </h5>
                            <div class="frame-wrap">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Avatar</th>
                                            <th>Role</th>
                                            <th>Email</th>
                                            <th>Username</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>
                                                <img src="<?=$avatar?>" width="75">
                                            </td>
                                            <td><?=$role?></td>
                                            <td><?=$user['email']?></td>
                                            <td><?=$user['login']?></td>
                                            <td><?=$status?></td>
                                            <td>
                                                <a href="edit.php?id=<?=$user['id']?>" class="btn btn-warning">Изменить</a>
                                                <a href="delete.php?id=<?=$user['id']?>" class="btn btn-danger">Удалить</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
