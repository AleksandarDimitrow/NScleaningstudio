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
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <h2>Вход</h2>

        <?php if ($msg): ?>
            <div class="auth-message"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="email" name="email" placeholder="Имейл" required>
            <input type="password" name="password" placeholder="Парола" required>
            <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
            <button type="submit">Влез</button>
        </form>

        <div class="auth-link">
            Нямаш акаунт? <a href="register.php?redirect=<?= urlencode($redirect) ?>">Регистрирай се</a>
        </div>
    </div>
</body>
</html>
