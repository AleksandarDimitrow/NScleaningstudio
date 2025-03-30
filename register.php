<?php
session_start();
include 'db.php';

$msg = "";
$redirect = $_GET['redirect'] ?? 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $phone    = trim($_POST["phone"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "Този имейл вече съществува!";
    } else {
        $query = "INSERT INTO users (name, email, password, phone)
                  VALUES ('$name', '$email', '$password', '$phone')";
        if (mysqli_query($conn, $query)) {
            $user_id = mysqli_insert_id($conn);
            $_SESSION["user_id"] = $user_id;
            $_SESSION["user_name"] = $name;
            header("Location: $redirect");
            exit();
        } else {
            $msg = "Грешка при регистрация!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
    <h2>Регистрация</h2>
    <?php if ($msg) echo "<p>$msg</p>"; ?>
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Име" required><br><br>
        <input type="email" name="email" placeholder="Имейл" required><br><br>
        <input type="text" name="phone" placeholder="Телефон"><br><br>
        <input type="password" name="password" placeholder="Парола" required><br><br>
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
        <button type="submit">Регистрирай се</button>
    </form>
</body>
</html>