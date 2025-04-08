<?php session_start(); ?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерия - NS Cleaning Studio</title>
    <link rel="stylesheet" href="assets/css/styles.css"> 
    <link rel="stylesheet" href="assets/css/gallery.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
<main>
    <section class="gallery-container">
        <h1>Нашата Галерия</h1>
        <div class="gallery">
            <img src="assets/img/photo1.jpg" alt="Снимка 1" class="gallery-item">
            <img src="assets/img/photo2.jpg" alt="Снимка 2" class="gallery-item">
            <img src="assets/img/photo3.jpg" alt="Снимка 3" class="gallery-item">
            <img src="assets/img/photo4.jpg" alt="Снимка 4" class="gallery-item">
            <img src="assets/img/photo5.jpg" alt="Снимка 5" class="gallery-item">
            <img src="assets/img/photo6.jpg" alt="Снимка 6" class="gallery-item">
            <img src="assets/img/photo7.jpg" alt="Снимка 7" class="gallery-item">
            <img src="assets/img/photo8.jpg" alt="Снимка 8" class="gallery-item">
            <img src="assets/img/photo9.jpg" alt="Снимка 9" class="gallery-item">
            <img src="assets/img/photo10.jpg" alt="Снимка 10" class="gallery-item">
        </div>
    </section>
</main>

<div id="lightbox">
    <span class="close">&times;</span>
    <img id="lightbox-img">
</div>

<script src="assets/js/gallery.js"></script>
</body>
</html>
