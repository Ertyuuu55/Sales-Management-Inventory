<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /supermarket-app/public/login.php");
    exit;
}

if ($_SESSION['role_id'] != 1) { 
    header("Location: /supermarket-app/public/staff/dashboard.php");
    exit;
}

require_once('../../controllers/admin/user_controller.php');
require_once('../../controllers/admin/role_controller.php');
require_once '../layout/sidebar.php';
$users = read_users_controller();
$roles = read_roles_controller();

$totalUsers = count($users);
$totalRoles = count($roles);

$staffUsers = [];
$adminUsers = [];

foreach ($users as $u) {
    if ($u['role_id'] == 2) {
        $staffUsers[] = $u;
    } elseif ($u['role_id'] == 1) {
        $adminUsers[] = $u;
    }
}

$totalStaff = count($staffUsers);
$totalAdmin = count($adminUsers);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Emoji -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <!-- CSS -->
     <link rel="stylesheet" href="../../assets/css/dashboard.css">

    <!-- JS -->
   <script src="../../assets/js/dashboard.js" async></script>
</head>
<body>
	<section id="content">
		<!-- NAVBAR -->
		<nav>
         <i class="bx bx-menu toggle-sidebar"></i>

         <form action="#">
            <div class="form-group">
               <input type="text" placeholder="Cari..">
            </div>
         </form>

         <span class="divider"></span>

         <div class="profile">
            <img src="../../assets/images/img-profile.jpg" alt="Profile">

            <a href="../logout.php" class="logout-inline">
               LOG OUT
            </a>
         </div>
      </nav>
		<!-- NAVBAR -->

      <!-- MAIN CONTENT -->
       <div class="main-content">
             <div id="dashboard-content" class="menu-content">
               <h1 class="main-title">Dashboard</h1>
            </div>

            <div class="dashboard-cards">
               <div class="card">
                  <h2><?= $totalUsers ?></h2>
                  <p>Total User</p>
               </div>

               <div class="card">
                  <h2><?= $totalStaff ?></h2>
                  <p>Total Staff</p>
               </div>

               <div class="card">
                  <h2><?= $totalAdmin ?></h2>
                  <p>Total Admin</p>
               </div>

               <div class="card">
                  <h2><?= $totalRoles ?></h2>
                  <p>Total Role</p>
               </div>
            </div>
            <h2>👨‍💼 Daftar Staff</h2>
            <table>
               <tr>
                  <th>ID</th>
                  <th>Username</th>
                  <th>Dibuat</th>
               </tr>
               <?php foreach ($staffUsers as $s): ?>
               <tr>
                  <td><?= $s['user_id'] ?></td>
                  <td><?= $s['username'] ?></td>
                  <td><?= $s['created_at'] ?></td>
               </tr>
               <?php endforeach; ?>
            </table>
            
            <h2>👑 Daftar Admin</h2>
            <table>
               <tr>
                  <th>ID</th>
                  <th>Username</th>
                  <th>Dibuat</th>
               </tr>
               <?php foreach ($adminUsers as $a): ?>
               <tr>
                  <td><?= $a['user_id'] ?></td>
                  <td><?= $a['username'] ?></td>
                  <td><?= $a['created_at'] ?></td>
               </tr>
               <?php endforeach; ?>
            </table>
            <h2>🛡️ Daftar Role</h2>
            <table>
               <tr>
                  <th>ID</th>
                  <th>Nama Role</th>
                  <th>Dibuat</th>
               </tr>
               <?php foreach ($roles as $r): ?>
               <tr>
                  <td><?= $r['role_id'] ?></td>
                  <td><?= $r['role_name'] ?></td>
                  <td><?= $r['created_at'] ?></td>
               </tr>
               <?php endforeach; ?>
            </table>

            
       </div>
      <!-- MAIN CONTENT -->
	</section>
</body>
</html>
