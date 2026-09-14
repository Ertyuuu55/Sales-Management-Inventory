<?php
require_once '../layout/header.php';
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /supermarket-app/public/login.php");
    exit;
}

if ($_SESSION['role_id'] != 1) {
    header("Location: /supermarket-app/public/staff/dashboard.php");
    exit;
}

require_once('../../controllers/admin/user_controller.php');
require_once '../layout/sidebar.php';

$users = read_users_controller();
?>

<!DOCTYPE html>
<html>
<head>
   <title>Kelola Staff</title>
   <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>
<body>

<section id="content">

<div class="main-content">
   <h1 class="main-title">👨‍💼 Kelola Staff</h1>

   <table>
      <thead>
         <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Dibuat</th>
            <th>Aksi</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($users as $u): ?>
            <?php if ($u['role_id'] == 2): ?>
               <tr>
                  <td><?= $u['user_id'] ?></td>
                  <td><?= htmlspecialchars($u['username']) ?></td>
                  <td><?= $u['created_at'] ?></td>
                  <td>
                     <a href="./user/edit_user.php?id=<?= $u['user_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                     <a href="./user/delete_user.php?id=<?= $u['user_id'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Hapus staff ini?')">Hapus</a>
                  </td>
               </tr>
            <?php endif; ?>
         <?php endforeach; ?>
      </tbody>
   </table>

   <a href="./user/add_user.php">
      <button class="btn btn-add-user">Tambah Staff</button>
   </a>
</div>
</section>

</body>
</html>