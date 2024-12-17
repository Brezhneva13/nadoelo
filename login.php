<?php
// Включаем отображение ошибок для отладки
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'db.php';

// Проверяем, был ли отправлен POST-запрос
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Подготавливаем SQL-запрос для поиска пользователя
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->execute(['username' => $username, 'password' => $password]);
    
    // Получаем данные пользователя
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Проверяем, найден ли пользователь
    if ($user) {
        // Сохраняем идентификатор пользователя в сессии
        $_SESSION['user_id'] = $user['id'];
        // Перенаправляем на панель управления
        header('Location: dashboard.php');
        exit;
    } else {
        // Если пользователь не найден, выводим сообщение об ошибке
        $error = "Неправильное имя пользователя или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <h1>Вход</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Войти</button>
    </form>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
</body>
</html>
