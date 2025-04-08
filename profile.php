<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=profile.php");
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];
$name = $_SESSION['user_name'];

$query = "SELECT * FROM bookings WHERE user_id = $user_id ORDER BY date, time";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Грешка при заявка: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Моят профил</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/profile.css">
</head>
<body>

<header class="header">
    <div class="top-bar">
        <span>📞 NS Cleaning Studio: 0885880558 | ✉ nscleaning@varna.bg</span>
    </div>
    <div class="nav-bar">
        <div class="logo">
            <a href="index.php"><img src="assets/img/logo.jpg" alt="NS Cleaning Studio Logo"></a>
        </div>
        <nav>
            <ul class="nav-links">
            <li><a href="index.php#home">Начало</a></li>
<li><a href="index.php#about">За нас</a></li>
<li><a href="booking.php">Услуги</a></li>
<li><a href="gallery.php">Галерия</a></li>

<?php
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $check_admin = mysqli_query($conn, "SELECT is_admin FROM users WHERE id = '$uid' LIMIT 1");
    $admin_data = mysqli_fetch_assoc($check_admin);
    if ($admin_data && $admin_data['is_admin'] == 1) {
        echo '<li><a href="admin.php">Админ панел</a></li>';
    }
    echo '<li><a href="profile.php">Профил</a></li>';
} else {
    echo '<li><a href="login.php?redirect=profile.php">Влез в профил</a></li>';
}
?>
<li><a href="index.php#contact">Контакти</a></li>
            </ul>
        </nav>
    </div>
</header>

<main style="padding: 40px;">
    <h2>Профил на <?= htmlspecialchars($name) ?></h2>

    <div class="profile-actions">
        <a href="logout.php" class="btn-profile">Изход</a>
        <a href="login.php?redirect=profile.php" class="btn-profile">Смени профила</a>
    </div>

    <h3>Моите запазени часове</h3>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Услуга</th>
                <th>Дата</th>
                <th>Час</th>
                <th>Опции</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['service']) ?></td>
                    <td><?= htmlspecialchars($row['date']) ?></td>
                    <td><?= htmlspecialchars($row['time']) ?></td>
                    <td>
                        <a href="edit_booking.php?id=<?= $row['id'] ?>">Редактирай</a> |
                        <a href="delete_booking.php?id=<?= $row['id'] ?>" onclick="return confirm('Сигурен ли си?')">Изтрий</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class="no-bookings">
            <p>Все още нямаш запазени часове.</p>
            <a href="booking.php" class="btn-profile">Запази час</a>
        </div>
    <?php endif; ?>
</main>

</body>
</html>
