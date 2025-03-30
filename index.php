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
                 <li><a href="#services">Услуги</a></li>
                 <li><a href="gallery.html">Галерия</a></li>
                 <li><a href="booking.php">Запази час</a></li>
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

        <!-- Услуги -->
        <section id="services" class="section">
            <h2>Нашите услуги</h2>
            <div class="services-container">
                <!-- Вътрешно почистване -->
                <div class="service-card">
                    <img src="assets/img/interioruslg.webp" alt="Interior">
                    <div class="service-card-content">
                        <h3 class="service-card-title">Детайлно вътрешно почистване</h3>
                        <p class="service-card-description">
                            - Почистване седалки и мокети<br>
                            - Почистване на педали и стелки<br>
                            - Табло, волан, прагове, багажник
                        </p>
                    </div>
                </div>
                <!-- Външно почистване -->
                <div class="service-card">
                    <img src="assets/img/exterioruslg.webp" alt="Exterior">
                    <div class="service-card-content">
                        <h3 class="service-card-title">Детайлно външно почистване</h3>
                        <p class="service-card-description">
                            - Измиване + джанти + подсушаване<br>
                            - Предварително обезмасляване
                        </p>
                    </div>
                </div>
                <!-- Полиране -->
                <div class="service-card">
                    <img src="assets/img/poliraneuslg.jpg" alt="Polish">
                    <div class="service-card-content">
                        <h3 class="service-card-title">Полиране и защита</h3>
                        <p class="service-card-description">
                            - Полиране на детайли или цял автомобил<br>
                            - Керамична защита на фарове и стъкла
                        </p>
                    </div>
                </div>
            </div>
        </section>

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