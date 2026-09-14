<?php
session_start();

/* CEK LOGIN */
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

require_once('../controllers/admin/user_controller.php');

/* Ambil user login */
$user = get_user_by_id_controller($_SESSION['user_id']);

/* Tentukan role & tujuan back */
$isAdmin = ($_SESSION['role_id'] == 2);

$roleName = $isAdmin ? 'Admin' : 'Staff';
$backLink = $isAdmin
    ? '/supermarket-app/public/admin/dashboard.php'
    : '/supermarket-app/public/staff/dashboard.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil <?= $roleName ?></title>

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <style>
        body {
            background:#f4f6f8;
            font-family: Arial, sans-serif;
        }

        .profile-box {
            width:420px;
            margin:80px auto;
            background:#fff;
            padding:25px;
            border-radius:10px;
            text-align:center;
            box-shadow:0 6px 16px rgba(0,0,0,.15);
        }

        .profile-icon {
            font-size:90px;
            color:#4a6cf7;
        }

        label {
            font-weight:bold;
            display:block;
            text-align:left;
            margin-top:15px;
        }

        input {
            width:100%;
            padding:9px;
            border-radius:6px;
            border:1px solid #ccc;
            background:#f9f9f9;
        }

        .btn-back {
            display:inline-block;
            margin-top:25px;
            background:red;
            color:white;
            padding:10px 22px;
            text-decoration:none;
            border-radius:6px;
            font-weight:bold;
        }

        .btn-back:hover {
            opacity:0.85;
        }
    </style>
</head>
<body>

<div class="profile-box">
    <div class="profile-icon">
        <i class='bx bxs-user-circle'></i>
    </div>

    <h2>Profil <?= $roleName ?></h2>

    <label>Username</label>
    <input type="text" value="<?= htmlspecialchars($user['username']) ?>" readonly>

    <label>Password</label>
    <input type="password" value="<?= htmlspecialchars($user['password']) ?>" readonly>
    
    <label>Akun Dibuat</label>
    <input type="text"
       value="<?= date('d M Y H:i', strtotime($user['created_at'])) ?>"
       readonly>

    <a href="<?= $backLink ?>" class="btn-back">Back</a>
</div>

</body>
</html>