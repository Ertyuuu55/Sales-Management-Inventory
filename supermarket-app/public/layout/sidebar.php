<?php
$role = $_SESSION['role_id'] ?? 0;
?>

<section id="sidebar">
<a href="#" class="brand"><i class='bx bxs-smile icon'></i> AdminSite</a>
<ul class="side-menu">

<?php if ($role == 1): // ADMIN ?>
    <li><a href="../admin/dashboard.php"><i class='bx bxs-widget icon'></i>Dashboard</a></li>
    <li><a href="../admin/kelolaStaff.php"><i class='bx bxs-widget icon'></i>Kelola Staff</a></li>
    <li><a href="../admin/kelolaRole.php"><i class='bx bxs-chart icon'></i>Kelola Role</a></li>
<?php endif; ?>


<?php if ($role == 2): // STAFF ?>
    <li><a href="../staff/dashboard.php"><i class='bx bxs-widget icon'></i> Dashboard</a></li>
    <li><a href="../staff/produk.php"><i class='bx bxs-widget icon'></i> Produk</a></li>
    <li><a href="../staff/kategori.php" class="menu-btn"><i class='bx bxs-widget icon'></i> Kategori</a></li>
    <li><a href="../staff/tambah_stok.php" class="menu-btn"><i class='bx bxs-chart icon'></i> Tambah Stok Produk</a></li>
    <li><a href="../staff/kurang_stok.php" class="menu-btn"><i class='bx bxs-chart icon'></i> Kurangi Stok Produk</a></li>
    <li><a href="../staff/supplier.php" class="menu-btn"><i class='bx bxs-truck icon'></i> Supplier</a></li>
    <li><a href="../staff/brand.php" class="menu-btn"><i class='bx bxs-truck icon'></i> Brand</a></li>
    <li><a href="../staff/laporan.php" class="menu-btn"><i class='bx bxs-report icon'></i>Laporan Stok</a></li>
<?php endif; ?>

</ul>
</section>
