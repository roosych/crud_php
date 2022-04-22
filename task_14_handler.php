<?php
session_start();

// Данные с формы
$email = $_POST['email'];
$password = $_POST['password'];

// Подключение к бд
try {
    $pdo = new PDO('mysql:host=localhost;dbname=tripdayaz_marlinphp', 'tripdayaz_admin', 'rusikkatv1');
}
catch(PDOException $e) {
    echo $e->getMessage();
}

// Получаем пользователя по введенному емейлу
$sql = 'SELECT * FROM users WHERE email = :email';
$statement = $pdo->prepare($sql);
$statement->execute(['email' => $email]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

// Проверяем наличие пользовтаеля в бд
if(empty($user)) {
    $msg = 'Неверный логин или пароль';
    $_SESSION['error'] = $msg;
    header('Location: /task_14.php');
    exit();
}

// Хешированный пароль записываем в переменную
$hash = $user['password'];

// Провереям совпадает ли хэшированный и введенный пароль
if (password_verify($password, $hash)){
    $_SESSION['user_email'] = $user['email'];
    header('Location: task_14.php');
    exit();
}

