<?php
require_once '../layout/header.php';

if (($_SESSION['role_id'] ?? 0) != 2) {
   header("Location: ../staff/dashboard.php");
   exit;
}

require_once '../layout/sidebar.php';
require_once '../../controllers/staff/brand_controller.php';

$brands = read_brand_controller();
?>

<section id="content">

<div class="main-content">
<h1>Daftar Brand</h1>

<table>
<thead>
<tr>
   <th>ID</th>
   <th>Nama Brand</th>
   <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php foreach ($brands as $b): ?>
<tr>
   <td><?= $b['brand_id'] ?></td>
   <td><?= htmlspecialchars($b['brand_name']) ?></td>
   <td>
      <a href="brand/edit_brand.php?id=<?= $b['brand_id'] ?>">Edit</a>
      <a href="brand/delete_brand.php?id=<?= $b['brand_id'] ?>"
         onclick="return confirm('Yakin hapus?')">Hapus</a>
   </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<a href="brand/add_brand.php">
   <button class="btn btn-add-user">Tambah Brand</button>
</a>
</div>
</section>
