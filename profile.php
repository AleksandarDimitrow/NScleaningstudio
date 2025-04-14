<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=profile.php");
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];
$name = $_SESSION['user_name'];
$msg = "";

// Вземи текущи данни на потребителя
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user_data = mysqli_fetch_assoc($user_query);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $current_password = $_POST['current_password'];
    $new_phone = trim($_POST['phone']);
    $new_email = trim($_POST['email']);
    $new_password = $_POST['new_password'];

    if (!password_verify($current_password, $user_data['password'])) {
        $msg = "❌ Невалидна текуща парола.";
    } else {
        $updates = [];

        // Имейл
        if (!empty($new_email) && $new_email !== $user_data['email']) {
            $email_check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$new_email' AND id != $user_id");
            if (mysqli_num_rows($email_check) > 0) {
                $msg = "❌ Този имейл вече се използва.";
            } else {
                $updates[] = "email = '" . mysqli_real_escape_string($conn, $new_email) . "'";
            }
        }

        // Телефон
        if (!empty($new_phone) && $new_phone !== $user_data['phone']) {
            $updates[] = "phone = '" . mysqli_real_escape_string($conn, $new_phone) . "'";
        }

        // Нова парола
        if (!empty($new_password)) {
            if (
                strlen($new_password) < 8 ||
                !preg_match('/[A-Z]/', $new_password) ||
                !preg_match('/[a-z]/', $new_password) ||
                !preg_match('/[0-9]/', $new_password) ||
                !preg_match('/[\W]/', $new_password)
            ) {
                $msg = "❌ Новата парола трябва да е поне 8 символа, с главна, малка буква, цифра и символ.";
            } else {
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $updates[] = "password = '$hashed'";
            }
        }

        // Изпълнение
        if (empty($msg) && !empty($updates)) {
            $sql = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = $user_id";
            if (mysqli_query($conn, $sql)) {
                $msg = "✅ Данните са обновени успешно!";
            } else {
                $msg = "⚠️ Грешка при обновяване!";
            }
        } elseif (empty($msg)) {
            $msg = "ℹ️ Няма направени промени.";
        }
    }

    // Презареждане на user_data след промяна
    $user_query = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
    $user_data = mysqli_fetch_assoc($user_query);
}

$query = "SELECT * FROM bookings WHERE user_id = $user_id ORDER BY date, time";
$result = mysqli_query($conn, $query);
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
                $check_admin = mysqli_query($conn, "SELECT is_admin FROM users WHERE id = '$user_id' LIMIT 1");
                $admin_data = mysqli_fetch_assoc($check_admin);
                if ($admin_data && $admin_data['is_admin'] == 1) {
                    echo '<li><a href="admin.php">Админ панел</a></li>';
                }
                ?>
                <li><a href="profile.php">Профил</a></li>
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

    <?php if ($msg): ?>
        <p style="text-align:center; color: orange; font-weight: bold;"><?= $msg ?></p>
    <?php endif; ?>

    <h3>Редактирай данни</h3>
    <form method="POST" class="edit-form">
        <label>Текуща парола (задължително):</label>
        <input type="password" name="current_password" required>

        <label>Имейл:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user_data['email']) ?>" required>

        <label>Телефон:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user_data['phone']) ?>">

        <label>Нова парола:</label>
        <input type="password" name="new_password" placeholder="Минимум 8 символа, с A-Z, a-z, 0-9, !@#">

        <button type="submit">Запази промените</button>
    </form>

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
