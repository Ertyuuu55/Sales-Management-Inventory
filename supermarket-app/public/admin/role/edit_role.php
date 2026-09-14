<?php
require_once('../../../controllers/admin/role_controller.php');

$role_id = $_GET['id'];
$role = read_role_by_id_controller($role_id);

// handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role_name = $_POST['role_name'];

    update_role_controller($role_id, $role_name);
    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Role</title>

  <!-- LINK BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-4">Edit Role</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nama Role</label>
        <input type="text" name="role_name" class="form-control" 
               value="<?= $role['role_name'] ?>" required>
      </div>
      <button type="submit" class="btn btn-warning">Update</button>
    </form>
  </div>
</body>
</html>

