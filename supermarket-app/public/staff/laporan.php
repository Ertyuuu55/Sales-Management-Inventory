<?php
require_once '../layout/header.php';

if (($_SESSION['role_id'] ?? 0) != 2) {
   header("Location: ../staff/dashboard.php");
   exit;
}

require_once '../layout/sidebar.php';

require_once '../../controllers/staff/stock_controller.php';

$restocks     = read_restock_history_controller();    // stok masuk
$adjustments  = read_stock_adjustment_controller();   // stok keluar

$stockLogs = [];

// STOK MASUK
foreach ($restocks as $r) {
    $stockLogs[] = [
        'product'  => $r['product_name'],
        'supplier' => $r['supplier_name'],
        'type'     => 'Masuk',
        'qty'      => '+' . $r['quantity_change'],
        'unit'     => $r['unit_name'],
        'date'     => $r['log_date']
    ];
}

// STOK KELUAR
foreach ($adjustments as $a) {
    $stockLogs[] = [
        'product'  => $a['product_name'],
        'supplier' => $a['supplier_name'],
        'type'     => 'Keluar',
        'qty'      => '-' . $a['quantity_removed'],
        'unit'     => $a['unit_name'],
        'date'     => $a['log_date']
    ];
}

// URUTKAN TERBARU
usort($stockLogs, function ($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});
?>

<section id = "content">
<div class="main-content">
   <h1>Histori Stok</h1>

   <table>
      <thead>
         <tr>
            <th>Produk</th>
            <th>Supplier</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Unit</th>
            <th>Tanggal</th>
         </tr>
      </thead>
      <tbody>
         <?php if (!empty($stockLogs)): ?>
            <?php foreach ($stockLogs as $log): ?>
               <tr>
                  <td><?= $log['product'] ?></td>
                  <td><?= $log['supplier'] ?></td>
                  <td>
                     <?php if ($log['type'] === 'Masuk'): ?>
                        <span style="color:green;font-weight:bold;">Masuk</span>
                     <?php else: ?>
                        <span style="color:red;font-weight:bold;">Keluar</span>
                     <?php endif; ?>
                  </td>
                  <td><?= $log['qty'] ?></td>
                  <td><?= $log['unit'] ?></td>
                  <td><?= date('d M Y H:i', strtotime($log['date'])) ?></td>
               </tr>
            <?php endforeach; ?>
         <?php else: ?>
            <tr>
               <td colspan="6" style="text-align:center;">Belum ada histori stok</td>
            </tr>
         <?php endif; ?>
      </tbody>
   </table>
</div>
</section>
