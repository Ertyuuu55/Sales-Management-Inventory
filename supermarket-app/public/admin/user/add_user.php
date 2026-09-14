<?php
require_once('../../../controllers/admin/user_controller.php');
require_once('../../../controllers/admin/role_controller.php');

// get role
$roles = read_roles_controller();

// insert user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role_id  = $_POST['role_id'];

    create_user_controller($username, $password, $role_id);
    header("Location: ../dashboard.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pengguna</title>

    <!-- LINK BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-5">Tambah Data Pengguna</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role_id" class="form-select" required>
          <option value="">-- Pilih Role --</option>
          <?php foreach ($roles as $role): ?>
            <option value="<?= $role['role_id'] ?>"><?= $role['role_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
  </div>
</body>
</html>