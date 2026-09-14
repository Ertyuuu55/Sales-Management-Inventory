<?php
session_start();
require "../config/db.php";

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username=? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    if ($password === $row['password']) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role_id'] = (int)$row['role_id'];

        if ($row['role_id'] == 1) {
            header("Location: /supermarket-app/public/admin/dashboard.php");
        } elseif ($row['role_id'] == 2) {
            header("Location: /supermarket-app/public/staff/dashboard.php");
        } else {
            header("Location: ../public/login.php?error=role");
        }
        exit;
    }

}

header("Location: ../public/login.php?error=1");
exit;
