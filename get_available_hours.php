<?php
include 'db.php';

$date = $_GET['date'] ?? '';
$exclude_id = $_GET['exclude'] ?? null;

if (!$date) {
    echo json_encode([]);
    exit;
}

$slots = ["08:00:00", "11:00:00", "14:00:00", "17:00:00"];
$available = [];

foreach ($slots as $slot) {
    $query = "SELECT * FROM bookings WHERE date = '$date' AND time = '$slot'";
    if ($exclude_id) {
        $query .= " AND id != " . intval($exclude_id);
    }

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 0) {
        $available[] = substr($slot, 0, 5); 
    }
}

echo json_encode($available);
