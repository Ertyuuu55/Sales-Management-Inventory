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
require_once('../../../controllers/staff/status_controller.php');

$brands = read_brand_controller();
$categories = read_categories_controller();
$suppliers = read_suppliers_controller();
$statuses = read_status_controller();

if (!isset($_GET['id'])) {
    header("Location: ../dashboard.php");
    exit;
}
$product_id = $_GET['id'];

$product = read_product_by_id_controller($product_id);

if (!$product) {
    echo "Produk tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $brand_id     = $_POST['brand_id'];
    $category_id  = $_POST['category_id'];
    $supplier_id  = $_POST['supplier_id'];
    $status_id    = $_POST['status_id'] !== '' ? $_POST['status_id'] : null;

    update_product_controller($product_id, $product_name, $brand_id, $category_id, $supplier_id, $status_id);
    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk</title>

  <!-- LINK BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-5">Edit Produk</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nama Produk</label>
        <input type="text" name="product_name" class="form-control" 
               value="<?= htmlspecialchars($product['product_name']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Brand</label>
        <select name="brand_id" class="form-select" required>
          <?php foreach ($brands as $brand): ?>
            <option value="<?= $brand['brand_id'] ?>" 
              <?= $brand['brand_id'] == $product['brand_id'] ? 'selected' : '' ?>>
              <?= $brand['brand_name'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select" required>
          <?php foreach ($categories as $category): ?>
            <option value="<?= $category['category_id'] ?>" 
              <?= $category['category_id'] == $product['category_id'] ? 'selected' : '' ?>>
              <?= $category['category_name'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Supplier</label>
        <select name="supplier_id" class="form-select" required>
          <?php foreach ($suppliers as $supplier): ?>
            <option value="<?= $supplier['supplier_id'] ?>" 
              <?= $supplier['supplier_id'] == $product['supplier_id'] ? 'selected' : '' ?>>
              <?= $supplier['supplier_name'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Status (Manual Override)</label>
        <select name="status_id" class="form-select">
          <option value="">-- Pilih Status --</option>
          <?php foreach ($statuses as $status): ?>
            <option value="<?= $status['status_id'] ?>"
              <?= isset($product['status_id']) && $product['status_id'] == $status['status_id'] ? 'selected' : '' ?>>
              <?= $status['status_name'] ?>
            </option>
          <?php endforeach; ?>
        </select>
        <small class="text-muted">Pilih "OTW" jika produk sedang dalam pembelian.</small>
      </div>

      <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
  </div>
</body>
</html>
