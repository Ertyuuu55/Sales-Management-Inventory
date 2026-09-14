<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
   header("Location: /supermarket-app/public/login.php");
   exit;
}
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
<section id = "content">
<nav>
    <i class="bx bx-menu toggle-sidebar"></i>

        <form action="#">
            <div class="form-group">
               <input type="text" placeholder="Cari..">
            </div>
         </form>

         <span class="divider"></span>

         <div class="profile">
            <a href="../logout.php" class="logout-inline">
               LOG OUT
            </a>
            <a href = "../profile.php">
               <img src="../../assets/images/img-profile.jpg" alt="Profile">
            </a>
         </div>
</nav>
</section>