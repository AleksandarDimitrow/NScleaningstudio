<?php session_start(); ?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NS Cleaning Studio</title>
    <link rel="stylesheet" href="assets/css/styles.css">
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
        <!-- Hero секция -->
        <section id="home" class="hero">
            <h1>NS Cleaning Studio</h1>
            <p>Детайлно почистване на автомобили</p>
            <a href="booking.php" class="btn-primary">Запази час</a>
        </section>

        <!-- За нас -->
        <section id="about" class="section about-section">
            <h2>За нас</h2>
            <p>Ние сме професионален екип, посветен на детайлното почистване и поддръжка на вашия автомобил. Използваме висококачествени продукти и модерни техники, за да осигурим максимален блясък и защита на вашето превозно средство.</p>

        <!-- Контакти -->
        <section id="contact" class="section contact-section">
            <h2>Контакти</h2>
            <p>📞 Телефон: 0885880558</p>
            <p>✉ Email: nscleaning@varna.bg</p>
            <p>📍 Адрес: гр. Варна, ул. Почистване 12</p>
        </section>
    </main>
</body>
</html>