<?php
require_once '../layout/header.php';

if (($_SESSION['role_id'] ?? 0) != 2) {
   header("Location: ../staff/dashboard.php");
   exit;
}

require_once '../layout/sidebar.php';
require_once '../../controllers/staff/category_controller.php';

$categories = read_categories_controller();
?>

<section id="content">

<div class="main-content">
<h1>Daftar Kategori</h1>

<table>
<thead>
<tr>
   <th>ID</th>
   <th>Nama Kategori</th>
   <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php foreach ($categories as $c): ?>
<tr>
   <td><?= $c['category_id'] ?></td>
   <td><?= htmlspecialchars($c['category_name']) ?></td>
   <td>
      <a href="category/edit_category.php?id=<?= $c['category_id'] ?>">Edit</a>
      <a href="category/delete_category.php?id=<?= $c['category_id'] ?>"
         onclick="return confirm('Yakin hapus?')">Hapus</a>
   </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<a href="category/add_category.php">
   <button class="btn btn-add-user">Tambah Kategori</button>
</a>
</div>
</section>
