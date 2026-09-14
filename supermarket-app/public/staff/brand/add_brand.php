<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /supermarket-app/public/login.php");
    exit;
}

require_once('../../../controllers/staff/brand_controller.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_name = $_POST['brand_name'];
    create_brand_controller($brand_name);
    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tambah Brand</title>

  <!-- LINK BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-5">Tambah Brand Baru</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nama Brand</label>
        <input type="text" name="brand_name" class="form-control" placeholder="Masukkan nama brand" required>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
  </div>
</body>
</html>
