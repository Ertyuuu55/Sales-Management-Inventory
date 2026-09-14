<?php
/***********************
 * PRODUK.PHP (ADMIN)
 ***********************/

require_once '../layout/header.php';

// 🔐 PROTEKSI ROLE
if (($_SESSION['role_id'] ?? 0) != 2) {
    header("Location: ../staff/dashboard.php");
    exit;
}

require_once '../layout/sidebar.php';

// CONTROLLER
require_once '../../controllers/staff/product_controller.php';

$products = read_product_controller();
?>

<section id="content">

<div class="main-content">
   <h1 class="main-title">Daftar Produk</h1>

   <table>
      <thead>
         <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Brand</th>
            <th>Stok</th>
            <th>Aksi</th>
         </tr>
      </thead>
      <tbody>
         <?php if (!empty($products)): ?>
            <?php foreach ($products as $p): ?>
               <tr>
                  <td><?= $p['product_id'] ?></td>
                  <td><?= htmlspecialchars($p['product_name']) ?></td>
                  <td><?= htmlspecialchars($p['category_name']) ?></td>
                  <td><?= htmlspecialchars($p['brand_name']) ?></td>
                  <td><?= $p['total_stock'] ?? 0 ?> <?= $p['unit_name'] ?? '' ?></td>
                  <td>
                     <a href="product/edit_product.php?id=<?= $p['product_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                     <a href="product/delete_product.php?id=<?= $p['product_id'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin hapus produk ini?')">
                        Hapus
                     </a>
                  </td>
               </tr>
            <?php endforeach; ?>
         <?php else: ?>
            <tr>
               <td colspan="6" style="text-align:center;">Data produk kosong</td>
            </tr>
         <?php endif; ?>
      </tbody>
   </table>

   <a href="product/add_product.php">
      <button class="btn btn-add-user">Tambah Produk</button>
   </a>
</div>
</section>