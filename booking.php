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

    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');

    $conflict_query = "SELECT * FROM bookings WHERE date = '$date' AND time = '$time'";
    $conflict_result = mysqli_query($conn, $conflict_query);

    // Не позволявай минал час за днешна дата
    if ($date === $current_date && $time <= $current_time) {
        $msg = "❌ Не можеш да запазиш за изминал час.";
    }
    elseif (mysqli_num_rows($conflict_result) > 0) {
        $msg = "❌ Този часови слот вече е зает. Моля, избери друг.";
    }
    else {
        $sql = "INSERT INTO bookings (user_id, service, date, time)
                VALUES ('$user_id', '$service', '$date', '$time')";
        if (mysqli_query($conn, $sql)) {
            $msg = "✅ Часът беше запазен успешно!";
        } else {
            $msg = "⚠️ Грешка при запазване: " . mysqli_error($conn);
        }
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
                    <p class="service-card-description">Седалки, мокети, табло, волан, прагове и багажник</p>
                    <p class="service-card-description">120-160 лева</p>
                    <p class="service-card-description">Според степента на замърсяване</p>
                </div>
            </div>
            <div class="service-card">
                <img src="assets/img/exterioruslg.webp" alt="Exterior">
                <div class="service-card-content">
                    <h3 class="service-card-title">Детайлно външно почистване</h3>
                    <p class="service-card-description">Предизмиване, измиване на джанти и подсушаване</p>
                    <p class="service-card-description">40-80 лева</p>
                    <p class="service-card-description">Според степента на замърсяване</p>
                </div>
            </div>
            <div class="service-card">
                <img src="assets/img/poliraneuslg.jpg" alt="Polish">
                <div class="service-card-content">
                    <h3 class="service-card-title">Полиране и защита</h3>
                    <p class="service-card-description">Полиране на фарове, детайли и керамика</p>
                    <p class="service-card-description">Цената варира строго индивидуално</p>
                    <p class="service-card-description">Свържете се с нас за повече информация</p>
                </div>
            </div>
        </div>
    </section>

    <h3>Запиши си час</h3>

    <?php if ($msg): ?>
        <p style="text-align:center; font-weight:bold;"><?= $msg ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="service">Услуга:</label><br>
        <select name="service" id="service" required>
            <option value="">-- Избери услуга --</option>
            <option value="Вътрешно детайлно почистване">Вътрешно детайлно почистване</option>
            <option value="Външно детайлно почистване">Външно детайлноп почистване</option>
            <option value="Полиране на детайл">Полиране на детайл</option>
            <option value="Полиране на фарове и стопове">Полиране фарове и стопове</option>
            <option value="Керамично покритие на детайл">Керамична защита на детайл</option>
        </select><br><br>

        <label for="date">Дата:</label><br>
        <input type="date" name="date" id="date" required min="<?= date('Y-m-d'); ?>"><br><br>

        <label for="time">Свободни слотове:</label><br>
        <select name="time" id="time" required>
            <option value="">-- Избери дата първо --</option>
        </select><br><br>

        <button type="submit">Запази</button>
    </form>
</main>

<script>
document.getElementById('date').addEventListener('change', function () {
    const date = this.value;
    const timeSelect = document.getElementById('time');

    fetch('get_available_hours.php?date=' + date)
        .then(res => res.json())
        .then(data => {
            timeSelect.innerHTML = '';

            if (data.length === 0) {
                const opt = document.createElement('option');
                opt.value = '';
                opt.textContent = 'Няма свободни слотове за тази дата';
                timeSelect.appendChild(opt);
            } else {
                const defaultOpt = document.createElement('option');
                defaultOpt.textContent = '-- Избери слот --';
                defaultOpt.value = '';
                timeSelect.appendChild(defaultOpt);

                data.forEach(slot => {
                    const opt = document.createElement('option');
                    opt.value = slot;
                    opt.textContent = slot + ' – ' + formatEnd(slot);
                    timeSelect.appendChild(opt);
                });
            }
        });

    function formatEnd(start) {
        const [h, m, s] = start.split(':').map(Number);
        let endHour = h + 3;
        if (endHour < 10) endHour = '0' + endHour;
        return endHour + ':00';
    }
});
</script>

</body>
</html>
