<?php
require_once('../../../controllers/admin/user_controller.php');
require_once('../../../controllers/admin/role_controller.php');

$user_id = $_GET['id'];
$user = read_user_by_id_controller($user_id);
$roles = read_roles_controller();

// handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role_id  = $_POST['role_id'];

    update_user_controller($user_id, $username, $password, $role_id);
    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Data Pengguna</title>

  <!-- LINK BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-5">Edit Data Pengguna</h2>
    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" 
               value="<?= $user['username'] ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="text" name="password" class="form-control" 
               value="<?= $user['password'] ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role_id" class="form-select" required>
          <?php foreach ($roles as $role): ?>
            <option value="<?= $role['role_id'] ?>" 
              <?= ($role['role_id'] == $user['role_id']) ? 'selected' : '' ?>>
              <?= $role['role_name'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-warning mt-3">Update</button>
    </form>
  </div>
</body>
</html>
