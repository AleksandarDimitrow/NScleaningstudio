<?php session_start(); ?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NS Cleaning Studio</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <script src="https://unpkg.com/scrollreveal"></script>
</head>
<body>
    <header class="header">
        <div class="top-bar">
            <span>📞 NS Cleaning Studio: 0885880558 | ✉ nscleaning@varna.bg</span>
        </div>
        <div class="nav-bar">
            <div class="logo">
                <img src="assets/img/logo.jpg" alt="NS Cleaning Studio Logo">
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

    <main>
        <section id="home" class="hero">
            <h1>NS Cleaning Studio</h1>
            <p>Детайлно почистване на автомобили</p>
            <a href="booking.php" class="btn-primary">Запази час</a>
        </section>

        <!-- За нас -->
        <section id="about" class="section about-section reveal">
            <h2>За нас</h2>
            <h2>За NS Cleaning Studio</h2>
<p>
    Добре дошли в <strong>NS Cleaning Studio</strong> – вашият доверен партньор за професионално <strong>детайлно почистване на автомобили</strong> във Варна!
</p>
<p>
    Основана с мисията да вдъхне нов живот на всеки автомобил, нашата фирма предлага <strong>висококачествени услуги</strong>, съчетаващи прецизност, иновативна техника и внимание към всеки детайл.
</p>
<p>
    Работим с утвърдени марки като <strong>Karcher</strong> и <strong>Makita</strong> и използваме само <strong>екологично съобразени препарати</strong>, безопасни за вас, вашите пътници и околната среда.
</p>
<p>
    Доверието на клиентите ни е най-голямото ни постижение – и ние се стремим да го заслужаваме всеки ден.
</p>

            <p>Работим с <strong>индустриални машини от най-висок клас</strong> и използваме <strong>екологично съобразени препарати</strong>, за да постигнем:</p>
            <ul class="about-benefits">
                <li>🚗 Вътрешно почистване: седалки, табло, стелки, мокети</li>
                <li>🚶️ Хигиена и премахване на бактерии и алергени</li>
                <li>✨ Полиране и защита: възстановяване на блясъка на екстериора</li>
            </ul>

            <div class="about-images">
                <div class="about-item">
                    <img src="assets/img/ekstraktor.png" alt="Екстрактор">
                    <div class="hover-text">Екстрактор Karcher Puzzi 10/2 Adv: пране на седалки и мокети с минимално време за изсъхване.</div>
                </div>
                <div class="about-item">
                    <img src="assets/img/prahosmukachka.jpg" alt="Прахосмукачка">
                    <div class="hover-text">Karcher WD 3: прахосмукачка за сухо и мокро почистване.</div>
                </div>
                <div class="about-item">
                    <img src="assets/img/parochistachka.jpg" alt="Парочистачка">
                    <div class="hover-text">SC 4 EasyFix: парочистачка с високо налягане за премахване на бактерии.</div>
                </div>
                <div class="about-item">
                    <img src="assets/img/parostruika.webp" alt="Пароструйка">
                    <div class="hover-text">Karcher K7 Compact: мощна водоструйка за външно измиване и защита на боята.</div>
                </div>
                <div class="about-item">
                    <img src="assets/img/polirmashina.jpg" alt="Полирмашина">
                    <div class="hover-text">Makita 9237CB: полиране на фарове, боя и хромирани детайли.</div>
                </div>
            </div>
        </section>
        <section class="section reveal" id="detailing-info">
    <h2>Какво включва детайлното почистване?</h2>
    <div class="detailing-columns">
        <div class="detail-card">
            <h3>Вътрешно почистване</h3>
            <ul>
                <li>Пране на седалки, таван и мокети</li>
                <li>Обработка на пластмаси, табло и детайли</li>
                <li>Почистване на багажник, прагове и вентилация</li>
                <li>Парочистене и неутрализиране на миризми</li>
            </ul>
        </div>
        <div class="detail-card">
            <h3>Външно почистване</h3>
            <ul>
                <li>Предизмиване и обезмасляване</li>
                <li>Измиване с активна пяна и ръчно подсушаване</li>
                <li>Джанти, арки и прагове</li>
                <li>Стъклени повърхности и гумени уплътнения</li>
            </ul>
        </div>
        <div class="detail-card">
            <h3>Полиране и защита</h3>
            <ul>
                <li>Полиране на фарове, детайли и боя</li>
                <li>Нанасяне на керамични покрития</li>
                <li>Защита от UV лъчи и драскотини</li>
                <li>Възстановяване на блясък и цвят</li>
            </ul>
        </div>
    </div>
</section>
        <!-- Контакти -->
        <section id="contact" class="section contact-section reveal">
            <h2>Контакти</h2>
            <p>📞 Телефон: 0885880558</p>
            <p>✉ Email: nscleaning@varna.bg</p>
            <p>📍 Адрес: гр. Варна, ул. Почистване 12</p>
        </section>
    </main>

    <script>
        ScrollReveal().reveal('.reveal', {
            distance: '50px',
            duration: 800,
            easing: 'ease-in-out',
            origin: 'bottom',
            interval: 200
        });
    </script>
</body>
</html>
