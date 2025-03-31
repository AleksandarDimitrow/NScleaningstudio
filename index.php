<?php session_start(); ?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NS Cleaning Studio</title>
    <link rel="stylesheet" href="assets/css/styles.css">
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
                    <li><a href="#home">Начало</a></li>
                    <li><a href="#about">За нас</a></li>
                    <li><a href="booking.php">Услуги</a></li>
                    <li><a href="gallery.php">Галерия</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="profile.php">Профил</a></li>
                    <?php else: ?>
                        <li><a href="login.php?redirect=profile.php">Влез в профил</a></li>
                    <?php endif; ?>
                    <li><a href="#contact">Контакти</a></li>
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
            <p>NS Cleaning Studio е екип от професионалисти, специализирани в <strong>детайлното почистване на автомобили</strong>. Нашата мисия е не просто да почистим колата ви, а да ѝ върнем <strong>първоначалния ѝ блясък и свежест</strong>.</p>

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
