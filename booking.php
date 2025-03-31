<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=booking.php");
    exit();
}
include 'db.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $service = $_POST['service'];
    $date    = $_POST['date'];
    $time    = $_POST['time'];

    $sql = "INSERT INTO bookings (user_id, service, date, time)
            VALUES ('$user_id', '$service', '$date', '$time')";

    if (mysqli_query($conn, $sql)) {
        $msg = "Часът беше запазен успешно!";
    } else {
        $msg = "Грешка при запазване: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Запази час</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/booking.css">
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
                <li><a href="profile.php">Профил</a></li>
                <li><a href="index.php#contact">Контакти</a></li>
            </ul>
        </nav>
    </div>
</header>

<main style="padding: 40px;">
<section id="services" class="section">
<h2>Нашите услуги</h2>
            <div class="services-container">
                <div class="service-card">
                    <img src="assets/img/interioruslg.webp" alt="Interior">
                    <div class="service-card-content">
                        <h3 class="service-card-title">Детайлно вътрешно почистване</h3>
                        <p class="service-card-description">
                            - Детайлно почистване седалки и мокети<br>
                            - Детайлно почистване на педали и стелки<br>
                            - Детайлно почистване на табло и волан<br>
                            - Детайлно почистване на прагове и багажник
                        </p>
                    </div>
                </div>
                <div class="service-card">
                    <img src="assets/img/exterioruslg.webp" alt="Exterior">
                    <div class="service-card-content">
                        <h3 class="service-card-title">Детайлно външно почистване</h3>
                        <p class="service-card-description">
                            - Външно предизмиване на автомобила<br>
                            - Детайлно външно измиване<br>
                            - Детайлно измиване на джанти<br>
                            - Подсушаване на автомобила
                        </p>
                    </div>
                </div>
                <div class="service-card">
                    <img src="assets/img/poliraneuslg.jpg" alt="Polish">
                    <div class="service-card-content">
                        <h3 class="service-card-title">Полиране и защита</h3>
                        <p class="service-card-description">
                            - Полиране на фарове и стопове<br>
                            - Полиране на детайли<br>
                            - Полиране на цялата кола<br>
                            - Керамика за фарове и стъкла
                        </p>
                    </div>
                </div>
            </div>
        </section>

    <h3>Запиши си час</h3>

    <?php if ($msg): ?>
        <p style="color: green;"><?= $msg ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="service">Услуга:</label><br>
        <select name="service" id="service" required>
            <option value="">-- Избери услуга --</option>
            <option value="Вътрешно почистване">Вътрешно почистване</option>
            <option value="Външно почистване">Външно почистване</option>
            <option value="Полиране и защита">Полиране и защита</option>
        </select><br><br>

        <label for="date">Дата:</label><br>
        <input type="date" name="date" required><br><br>

        <label for="time">Час:</label><br>
        <input type="time" name="time" required><br><br>

        <button type="submit">Запази</button>
    </form>
</main>

</body>
</html>
