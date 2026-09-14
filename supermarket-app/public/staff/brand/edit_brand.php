<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /supermarket-app/public/login.php");
    exit;
}

require_once('../../../controllers/staff/brand_controller.php');

if (!isset($_GET['id'])) {
    header("Location: ../dashboard.php");
    exit;
}
$brand_id = $_GET['id'];
$brand = read_brand_by_id_controller($brand_id);

if (!$brand) {
    echo "Brand tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand_name = $_POST['brand_name'];
    update_brand_controller($brand_id, $brand_name);
    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Brand</title>

  <!-- LINK BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-5">Edit Brand</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nama Brand</label>
        <input type="text" name="brand_name" class="form-control" 
               value="<?= htmlspecialchars($brand['brand_name']) ?>" required>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
  </div>
</body>
</html>
