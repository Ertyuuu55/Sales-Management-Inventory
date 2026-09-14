<?php
require_once '../layout/header.php';

if (($_SESSION['role_id'] ?? 0) != 2) {
   header("Location: ../staff/dashboard.php");
   exit;
}

require_once '../layout/sidebar.php';
require_once '../../controllers/staff/stock_controller.php';

$stocks = read_all_stocks_controller();
?>

<section id="content">

<div class="main-content">
<h1>Tambah Stok</h1>

<table>
<thead>
<tr>
   <th>Produk</th>
   <th>Stok Saat Ini</th>
   <th>Tambah</th>
   <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php foreach ($stocks as $s): ?>
<tr>
<form method="POST" action="../staff/stock/add_stock.php">
   <td><?= htmlspecialchars($s['product_name']) ?></td>
   <td><?= $s['total_stock'] ?></td>
   <td>
      <input type="number" name="quantity" min="1" required>
      <input type="hidden" name="product_id" value="<?= $s['product_id'] ?>">
      <input type="hidden" name="unit_id" value="<?= $s['unit_id'] ?>">
      <input type="hidden" name="supplier_id" value="<?= $s['supplier_id'] ?>">
   </td>
   <td><button type="submit">Tambah</button></td>
</form>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</section>

