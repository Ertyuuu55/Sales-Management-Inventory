<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /supermarket-app/public/login.php");
    exit;
}

require_once('../../../controllers/staff/supplier_controller.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplier_name    = $_POST['supplier_name'];
    $supplier_address = $_POST['supplier_address'];
    $supplier_phone   = $_POST['supplier_phoneNum'];

    create_supplier_controller($supplier_name, $supplier_address, $supplier_phone);
    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tambah Supplier</title>

  <!-- LINK BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-5">Tambah Supplier Baru</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nama Supplier</label>
        <input type="text" name="supplier_name" class="form-control" placeholder="Masukkan nama supplier" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Alamat Supplier</label>
        <input type="text" name="supplier_address" class="form-control" placeholder="Masukkan alamat supplier" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Nomor Telepon</label>
        <input type="text" name="supplier_phoneNum" class="form-control" placeholder="Masukkan nomor telepon" required>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
  </div>
</body>
</html>
