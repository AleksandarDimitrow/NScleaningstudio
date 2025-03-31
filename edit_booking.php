<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=profile.php");
    exit();
}

include 'db.php';

$user_id = $_SESSION['user_id'];
$booking_id = $_GET['id'] ?? 0;

// Провери дали този час принадлежи на логнатия потребител
$check = mysqli_query($conn, "SELECT * FROM bookings WHERE id = $booking_id AND user_id = $user_id");
if (mysqli_num_rows($check) !== 1) {
    echo "Нямаш достъп до този час.";
    exit();
}

$row = mysqli_fetch_assoc($check);
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service = $_POST['service'];
    $date    = $_POST['date'];
    $time    = $_POST['time'];

    $update = "UPDATE bookings SET service='$service', date='$date', time='$time' WHERE id=$booking_id AND user_id=$user_id";
    if (mysqli_query($conn, $update)) {
        header("Location: profile.php");
        exit();
    } else {
        $msg = "Грешка при редакция!";
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Редакция на час</title>
</head>
<body>
    <h2>Редактирай своя час</h2>
    <?php if ($msg) echo "<p>$msg</p>"; ?>

    <form method="POST">
        <label>Услуга:</label><br>
        <select name="service" required>
            <option value="Вътрешно почистване" <?= $row['service'] === 'Вътрешно почистване' ? 'selected' : '' ?>>Вътрешно почистване</option>
            <option value="Външно почистване" <?= $row['service'] === 'Външно почистване' ? 'selected' : '' ?>>Външно почистване</option>
            <option value="Полиране и защита" <?= $row['service'] === 'Полиране и защита' ? 'selected' : '' ?>>Полиране и защита</option>
        </select><br><br>

        <label>Дата:</label><br>
        <input type="date" name="date" value="<?= $row['date'] ?>" required><br><br>

        <label>Час:</label><br>
        <input type="time" name="time" value="<?= $row['time'] ?>" required><br><br>

        <button type="submit">Запази промените</button>
    </form>
</body>
</html>
