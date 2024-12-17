<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$total_clients = $pdo->query("SELECT COUNT(*) FROM Client")->fetchColumn();
$total_transactions = $pdo->query("SELECT COUNT(*) FROM Transaction")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статистика</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Статистика</h1>
    <canvas id="statisticsChart" width="400" height="200"></canvas>
    <script>
        const ctx = document.getElementById('statisticsChart').getContext('2d');
        const statisticsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Клиенты', 'Транзакции'],
                datasets: [{
                    label: 'Количество',
                    data: [<?= $total_clients ?>, <?= $total_transactions ?>],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
