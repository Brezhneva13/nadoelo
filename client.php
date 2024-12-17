<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Добавление или редактирование записи клиента
    $clientNumber = $_POST['ClientNumber'];
    $phone = $_POST['Phone'];
    $address = $_POST['Address'];
    $cardNumber = $_POST['CardNumber'];
    $name = $_POST['Name'];
    $surname = $_POST['Surname'];
    $patronymic = $_POST['Patronymic'];
    $bankNumber = $_POST['BankNumber'];

    if ($clientNumber) {
        // Обновление существующего клиента
        $stmt = $pdo->prepare("UPDATE Client SET Phone=?, Address=?, CardNumber=?, Name=?, Surname=?, Patronymic=?, BankNumber=? WHERE ClientNumber=?");
        $stmt->execute([$phone, $address, $cardNumber, $name, $surname, $patronymic, $bankNumber, $clientNumber]);
    } else {
        // Добавление нового клиента
        $stmt = $pdo->prepare("INSERT INTO Client (Phone, Address, CardNumber, Name, Surname, Patronymic, BankNumber) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$phone, $address, $cardNumber, $name, $surname, $patronymic, $bankNumber]);
    }
}

$clients = $pdo->query("SELECT * FROM Client")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление клиентами</title>
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <h1>Управление клиентами</h1>
    <table>
        <thead>
            <tr>
                <th>Номер клиента</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>Номер карты</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Отчество</th>
                <th>Номер банка</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= htmlspecialchars($client['ClientNumber']) ?></td>
                    <td><?= htmlspecialchars($client['Phone']) ?></td>
                    <td><?= htmlspecialchars($client['Address']) ?></td>
                    <td><?= htmlspecialchars($client['CardNumber']) ?></td>
                    <td><?= htmlspecialchars($client['Name']) ?></td>
                    <td><?= htmlspecialchars($client['Surname']) ?></td>
                    <td><?= htmlspecialchars($client['Patronymic']) ?></td>
                    <td><?= htmlspecialchars($client['BankNumber']) ?></td>
                    <td>
                        <a href="client.php?edit=<?= $client['ClientNumber'] ?>">Редактировать</a>
                        <a href="client.php?delete=<?= $client['ClientNumber'] ?>">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Добавить/Редактировать клиента</h2>
    <form method="POST">
        <input type="hidden" name="ClientNumber" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '' ?>">
        <input type="text" name="Phone" placeholder="Телефон" required>
        <input type="text" name="Address" placeholder="Адрес">
        <input type="text" name="CardNumber" placeholder="Номер карты">
        <input type="text" name="Name" placeholder="Имя" required>
        <input type="text" name="Surname" placeholder="Фамилия" required>
        <input type="text" name="Patronymic" placeholder="Отчество">
        <input type="text" name="BankNumber" placeholder="Номер банка">
        <button type="submit">Сохранить</button>
    </form>
</body>
</html>
