<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель управления</title>
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <h1>Панель управления</h1>
    <a href="client.php">Управление клиентами</a>
    <a href="bank.php">Управление банками</a>
    <a href="terminal.php">Управление терминалами</a>
    <a href="transaction.php">Управление транзакциями</a>
    <a href="attempt.php">Управление попытками</a>
    <a href="card_type.php">Управление типами карт</a>
    <a href="client_status.php">Управление статусами клиентов</a>
    <a href="transaction_status.php">Управление статусами транзакций</a>
    <a href="interval.php">Управление интервалами</a>
    <a href="statistics.php">Статистика</a>
    <a href="logout.php">Выйти</a>
</body>
</html>
