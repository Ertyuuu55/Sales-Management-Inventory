<?php
session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../staff/dashboard.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

<div class="login-box">
    <h2>Login</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error">Username atau password salah!</p>
    <?php endif; ?>

    <form action="../controllers/auth_login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>
 
</div>

</body>
</html>
