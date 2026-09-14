<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /supermarket-app/public/login.php");
    exit;
}

require_once('../../../controllers/staff/product_controller.php');
require_once('../../../controllers/staff/brand_controller.php');
require_once('../../../controllers/staff/category_controller.php');
require_once('../../../controllers/staff/supplier_controller.php');
require_once('../../../controllers/staff/unit_controller.php');

$brands = read_brand_controller();
$categories = read_categories_controller();
$suppliers = read_suppliers_controller();
$units = read_units_controller();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $brand_id     = $_POST['brand_id'];
    $category_id  = $_POST['category_id'];
    $supplier_id  = $_POST['supplier_id'];
    $unit_id  = $_POST['unit_id'];

    insert_product_controller($product_name, $brand_id, $category_id, $supplier_id, $unit_id);
    header("Location: ../dashboard.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Produk</title>

  <!-- LINK BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-5">Tambah Produk Baru</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nama Produk</label>
        <input type="text" name="product_name" class="form-control" placeholder="Masukkan nama produk" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Brand</label>
        <select name="brand_id" class="form-select" required>
          <option value="">-- Pilih Brand --</option>
          <?php foreach ($brands as $brand): ?>
            <option value="<?= $brand['brand_id'] ?>"><?= $brand['brand_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select" required>
          <option value="">-- Pilih Kategori --</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Supplier</label>
        <select name="supplier_id" class="form-select" required>
          <option value="">-- Pilih Supplier --</option>
          <?php foreach ($suppliers as $supplier): ?>
            <option value="<?= $supplier['supplier_id'] ?>"><?= $supplier['supplier_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Unit Produk</label>
        <select name="unit_id" class="form-select" required>
          <?php foreach ($units as $unit): ?>
            <option value="<?= $unit['unit_id'] ?>"><?= $unit['unit_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
  </div>
</body>
</html>
