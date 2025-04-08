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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
    include_once 'db.php'; // Добави само ако още не е включен
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

    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="service">Запиши си час</label>
        <label for="service">Услуга:</label>
        <select name="service" id="service" required>
            <option value="">-- Избери услуга --</option>
            <option value="Вътрешно детайлно почистване">Вътрешно детайлно почистване</option>
            <option value="Външно детайлно почистване">Външно детайлно почистване</option>
            <option value="Полиране на детайл">Полиране на детайл</option>
            <option value="Полиране на фарове и стопове">Полиране фарове и стопове</option>
            <option value="Керамично покритие на детайл">Керамична защита на детайл</option>
        </select>

        <label for="date">Дата:</label>
        <input type="text" name="date" id="date" required>

        <label for="time">Свободни слотове:</label>
        <select name="time" id="time" required>
            <option value="">-- Избери дата първо --</option>
        </select>

        <button type="submit">Запази</button>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
                    opt.textContent = slot.slice(0,5) + ' – ' + formatEnd(slot);
                    timeSelect.appendChild(opt);
                });
            }
        });

    function formatEnd(start) {
        const [h] = start.split(':').map(Number);
        let endHour = h + 3;
        if (endHour < 10) endHour = '0' + endHour;
        return endHour + ':00';
    }
});

flatpickr("#date", {
    minDate: "today",
    dateFormat: "Y-m-d",
    disableMobile: true
});
</script>
</body>
</html>