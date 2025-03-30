<?php
session_start();
include 'db.php';

$msg = "";
$redirect = $_GET['redirect'] ?? 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            header("Location: $redirect");
            exit();
        } else {
            $msg = "Грешна парола!";
        }
    } else {
        $msg = "Потребителят не съществува!";
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
</head>
<body>
    <h2>Вход</h2>
    <?php if ($msg) echo "<p>$msg</p>"; ?>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Имейл" required><br><br>
        <input type="password" name="password" placeholder="Парола" required><br><br>
        <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
        <button type="submit">Влез</button>
    </form>
    <p>Нямаш акаунт? <a href="register.php?redirect=<?= urlencode($redirect) ?>">Регистрирай се</a></p>
</body>
</html>