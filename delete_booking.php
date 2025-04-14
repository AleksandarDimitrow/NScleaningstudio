<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=profile.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$booking_id = $_GET['id'] ?? 0;

// Проверка дали е админ
$is_admin = false;
$admin_check = mysqli_query($conn, "SELECT is_admin FROM users WHERE id = $user_id LIMIT 1");
if ($admin_check && mysqli_num_rows($admin_check) === 1) {
    $admin_data = mysqli_fetch_assoc($admin_check);
    $is_admin = $admin_data['is_admin'] == 1;
}

// Проверка дали потребителят има право да трие тази резервация
$condition = $is_admin ? "id = $booking_id" : "id = $booking_id AND user_id = $user_id";
$check = mysqli_query($conn, "SELECT * FROM bookings WHERE $condition");

if (!$check || mysqli_num_rows($check) !== 1) {
    echo "⛔ Нямаш право да изтриеш тази резервация.";
    exit();
}

// Изтриване
$delete = mysqli_query($conn, "DELETE FROM bookings WHERE id = $booking_id");

if ($delete) {
    $redirect = $is_admin ? 'admin.php' : 'profile.php';
    header("Location: $redirect");
    exit();
} else {
    echo "⚠️ Възникна грешка при изтриване.";
}
