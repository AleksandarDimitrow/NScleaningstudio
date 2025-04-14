<?php
session_start();
include 'db.php';

$msg = "";
$redirect = $_GET['redirect'] ?? 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $phone    = trim($_POST["phone"]);
    $password = $_POST["password"];

    // Сигурна валидация на парола
    if (
        strlen($password) < 8 ||
        !preg_match('/[A-Z]/', $password) ||        // Главна буква
        !preg_match('/[a-z]/', $password) ||        // Малка буква
        !preg_match('/[0-9]/', $password) ||        // Цифра
        !preg_match('/[\W]/', $password)            // Специален символ
    ) {
        $msg = "Паролата трябва да е поне 8 символа и да съдържа главна, малка буква, цифра и специален символ.";
    } else {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $msg = "Този имейл вече съществува!";
        } else {
            $query = "INSERT INTO users (name, email, password, phone)
                      VALUES ('$name', '$email', '$password_hashed', '$phone')";
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
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <h2>Регистрация</h2>

        <?php if ($msg): ?>
            <div class="auth-message"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="name" placeholder="Име" required>
            <input type="email" name="email" placeholder="Имейл" required>
            <input type="text" name="phone" placeholder="Телефон">
            <input type="password" name="password" id="password" placeholder="Парола" required>

            <label style="font-size: 0.9rem; text-align: left;">
                <input type="checkbox" onclick="togglePassword()"> Покажи паролата
            </label>

            <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
            <button type="submit">Регистрирай се</button>
        </form>

        <div class="auth-link">
            Вече имаш акаунт? <a href="login.php?redirect=<?= urlencode($redirect) ?>">Влез тук</a>
        </div>
    </div>

    <script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
    }
    </script>
</body>
</html>
