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

require_once('../../controllers/admin/role_controller.php');
require_once '../layout/sidebar.php';

$roles = read_roles_controller();
?>

<!DOCTYPE html>
<html>
<head>
   <title>Kelola Role</title>
   <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>
<body>

<section id="content">

<div class="main-content">
   <h1 class="main-title">🛡️ Kelola Role</h1>

   <table>
      <thead>
         <tr>
            <th>ID</th>
            <th>Nama Role</th>
            <th>Dibuat</th>
            <th>Aksi</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($roles as $r): ?>
            <tr>
               <td><?= $r['role_id'] ?></td>
               <td><?= htmlspecialchars($r['role_name']) ?></td>
               <td><?= $r['created_at'] ?></td>
               <td>
                  <a href="./role/edit_role.php?id=<?= $r['role_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
               </td>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>

   <a href="./role/add_role.php">
      <button class="btn btn-add-user">Tambah Role</button>
   </a>
</div>
</section>

</body>
</html>
