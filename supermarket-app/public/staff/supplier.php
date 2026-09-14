<?php
require_once '../layout/header.php';

if (($_SESSION['role_id'] ?? 0) != 2) {
   header("Location: ../staff/dashboard.php");
   exit;
}

require_once '../layout/sidebar.php';
require_once '../../controllers/staff/supplier_controller.php';

$suppliers = read_suppliers_controller();
?>

<section id="content">

<div class="main-content">
<h1>Daftar Supplier</h1>

<table>
<thead>
<tr>
   <th>ID</th>
   <th>Nama</th>
   <th>Alamat</th>
   <th>Telepon</th>
   <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php foreach ($suppliers as $s): ?>
<tr>
   <td><?= $s['supplier_id'] ?></td>
   <td><?= htmlspecialchars($s['supplier_name']) ?></td>
   <td><?= htmlspecialchars($s['supplier_address']) ?></td>
   <td><?= htmlspecialchars($s['supplier_phoneNum']) ?></td>
   <td>
      <a href="supplier/edit_supplier.php?id=<?= $s['supplier_id'] ?>">Edit</a>
      <a href="supplier/delete_supplier.php?id=<?= $s['supplier_id'] ?>"
         onclick="return confirm('Yakin hapus?')">Hapus</a>
   </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<a href="supplier/add_supplier.php">
   <button class="btn btn-add-user">Tambah Supplier</button>
</a>
</div>
</section>
