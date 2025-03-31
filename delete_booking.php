<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=profile.php");
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];
$booking_id = $_GET['id'] ?? 0;

// Проверка дали този час принадлежи на текущия потребител
$check = mysqli_query($conn, "SELECT * FROM bookings WHERE id = $booking_id AND user_id = $user_id");
if (mysqli_num_rows($check) !== 1) {
    echo "Нямаш право да изтриеш този час.";
    exit();
}

$delete = "DELETE FROM bookings WHERE id = $booking_id AND user_id = $user_id";
if (mysqli_query($conn, $delete)) {
    header("Location: profile.php");
    exit();
} else {
    echo "Грешка при изтриване!";
}
?>
