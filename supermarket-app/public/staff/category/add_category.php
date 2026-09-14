<?php
require_once('../../../controllers/staff/category_controller.php');

// handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];

    create_category_controller($category_name);
    header("Location: ../dashboard.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Kategori</title>

  <!-- LINK BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-4">Tambah Kategori</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nama Kategori</label>
        <input type="text" name="category_name" class="form-control" placeholder="Masukkan jenis kategori" required>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</body>
</html>

