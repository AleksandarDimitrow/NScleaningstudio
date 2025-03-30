<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=booking.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Запази час</title>
</head>
<body>
    <h2>Запази час</h2>
    <p>Добре дошъл, <?= htmlspecialchars($_SESSION['user_name']) ?>! Тук ще можеш да запазиш час скоро...
    <a href="logout.php" style="color: #f39c12; text-decoration: underline; margin-left: 15px;">Изход</a>
</p>
</body>
</html>
