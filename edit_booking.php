<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=edit_booking.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$booking_id = $_GET['id'] ?? 0;

// Проверка дали потребителят е админ
$is_admin = false;
$admin_check = mysqli_query($conn, "SELECT is_admin FROM users WHERE id = $user_id");
if ($admin_check && mysqli_num_rows($admin_check) === 1) {
    $admin_data = mysqli_fetch_assoc($admin_check);
    $is_admin = $admin_data['is_admin'] == 1;
}

// Проверка дали може да достъпва резервацията
$condition = $is_admin ? "id = $booking_id" : "id = $booking_id AND user_id = $user_id";
$check = mysqli_query($conn, "SELECT * FROM bookings WHERE $condition");

if (mysqli_num_rows($check) !== 1) {
    echo "⛔ Нямаш достъп до този час.";
    exit();
}

$row = mysqli_fetch_assoc($check);
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service = $_POST['service'];
    $date    = $_POST['date'];
    $time    = $_POST['time'];

    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');

    $conflict_query = "SELECT * FROM bookings WHERE date = '$date' AND time = '$time' AND id != $booking_id";
    $conflict_result = mysqli_query($conn, $conflict_query);

    if ($date === $current_date && $time <= $current_time) {
        $msg = "❌ Не можеш да запазиш за изминал час.";
    } elseif (mysqli_num_rows($conflict_result) > 0) {
        $msg = "❌ Този часови слот вече е зает. Моля, избери друг.";
    } else {
        $update = "UPDATE bookings SET service='$service', date='$date', time='$time' WHERE id=$booking_id";
        if (mysqli_query($conn, $update)) {
            $redirect = $is_admin ? 'admin.php' : 'profile.php';
            header("Location: $redirect");
            exit();
        } else {
            $msg = "⚠️ Грешка при редакция!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Редакция на резервация</title>
    <link rel="stylesheet" href="assets/css/edit_booking.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <h2>Редакция на резервация</h2>
    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Услуга:</label>
        <select name="service" required>
            <option value="Вътрешно детайлно почистване" <?= $row['service'] === 'Вътрешно детайлно почистване' ? 'selected' : '' ?>>Вътрешно детайлно почистване</option>
            <option value="Външно детайлно почистване" <?= $row['service'] === 'Външно детайлно почистване' ? 'selected' : '' ?>>Външно детайлно почистване</option>
            <option value="Полиране на детайл" <?= $row['service'] === 'Полиране на детайл' ? 'selected' : '' ?>>Полиране на детайл</option>
            <option value="Полиране на фарове и стопове" <?= $row['service'] === 'Полиране на фарове и стопове' ? 'selected' : '' ?>>Полиране на фарове и стопове</option>
            <option value="Керамично покритие на детайл" <?= $row['service'] === 'Керамично покритие на детайл' ? 'selected' : '' ?>>Керамична защита на детайл</option>
        </select>

        <label>Дата:</label>
        <input type="text" name="date" id="date" value="<?= $row['date'] ?>" required>

        <label>Свободни часове:</label>
        <select name="time" id="time" required>
            <option value="<?= $row['time'] ?>"><?= $row['time'] ?> (текущ)</option>
        </select>

        <button type="submit">Запази промените</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#date", {
            minDate: "today",
            dateFormat: "Y-m-d",
            disableMobile: true,
            defaultDate: "<?= $row['date'] ?>"
        });

        document.getElementById('date').addEventListener('change', function () {
            const date = this.value;
            const timeSelect = document.getElementById('time');

            fetch('get_available_hours.php?date=' + date + '&exclude=<?= $row['id'] ?>')
                .then(res => res.json())
                .then(data => {
                    timeSelect.innerHTML = '';

                    if (data.length === 0) {
                        const opt = document.createElement('option');
                        opt.value = '';
                        opt.textContent = 'Няма свободни слотове';
                        timeSelect.appendChild(opt);
                    } else {
                        const defaultOpt = document.createElement('option');
                        defaultOpt.value = '';
                        defaultOpt.textContent = '-- Избери нов слот --';
                        timeSelect.appendChild(defaultOpt);

                        data.forEach(slot => {
                            const opt = document.createElement('option');
                            opt.value = slot;
                            opt.textContent = slot.slice(0, 5) + ' – ' + formatEnd(slot);
                            timeSelect.appendChild(opt);
                        });
                    }
                });

            function formatEnd(start) {
                const [h] = start.split(':').map(Number);
                let endHour = h + 3;
                return (endHour < 10 ? '0' + endHour : endHour) + ':00';
            }
        });
    </script>
</body>
</html>
