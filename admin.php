<?php
session_start();
include 'db.php';

// Ако не е логнат или не е админ, го пращаме към login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=admin.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$check_admin = mysqli_query($conn, "SELECT is_admin FROM users WHERE id = '$user_id' LIMIT 1");
$admin_data = mysqli_fetch_assoc($check_admin);

if (!$admin_data || $admin_data['is_admin'] != 1) {
    echo "⛔ Нямаш достъп до тази страница.";
    exit();
}

// Извличане на всички резервации
$query = "SELECT b.*, u.name, u.email, u.phone 
          FROM bookings b
          JOIN users u ON b.user_id = u.id
          ORDER BY b.date DESC, b.time DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Админ панел</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <header class="header">
        <div class="top-bar">
            <span>🔐 Админ панел - NS Cleaning Studio</span>
        </div>
        <div class="nav-bar">
            <div class="logo">
                <a href="index.php"><img src="assets/img/logo.jpg" alt="Logo"></a>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php#home">Начало</a></li>
                    <li><a href="index.php#about">За нас</a></li>
                    <li><a href="booking.php">Услуги</a></li>
                    <li><a href="gallery.php">Галерия</a></li>
                    <li><a href="admin.php">Админ панел</a></li>
                    <li><a href="profile.php">Профил</a></li>
                    <li><a href="index.php#contact">Контакти</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main style="padding: 40px;">
        <h2>📋 Всички резервации</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Име</th>
                    <th>Email</th>
                    <th>Телефон</th>
                    <th>Услуга</th>
                    <th>Дата</th>
                    <th>Час</th>
                    <th>Създадена на</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['service']) ?></td>
                    <td><?= $row['date'] ?></td>
                    <td><?= $row['time'] ?></td>
                    <td><?= $row['created_at'] ?? '---' ?></td>
                    <td>
                        <a href="edit_booking.php?id=<?= $row['id'] ?>" class="btn-small">Редактирай</a>
                        <a href="delete_booking.php?id=<?= $row['id'] ?>" class="btn-small danger" onclick="return confirm('Сигурен ли си, че искаш да изтриеш тази резервация?')">Изтрий</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
