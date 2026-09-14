<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /supermarket-app/public/login.php");
    exit;
}

if ($_SESSION['role_id'] != 2) { 
    header("Location: /supermarket-app/public/staff/dashboard.php");
    exit;
}

require_once('../../controllers/admin/user_controller.php');
require_once('../../controllers/admin/role_controller.php');
require_once('../../controllers/staff/product_controller.php');
require_once('../../controllers/staff/category_controller.php');
require_once('../../controllers/staff/brand_controller.php');
require_once('../../controllers/staff/supplier_controller.php');
require_once('../../controllers/staff/stock_controller.php');
require_once('../../controllers/staff/unit_controller.php');
require_once('../../controllers/staff/status_controller.php');
require_once '../layout/sidebar.php';
$users = read_users_controller();
$roles = read_roles_controller();
$products = read_product_controller();
$categories = read_categories_controller();
$brands = read_brand_controller();
$suppliers = read_suppliers_controller();
$stocks = read_all_stocks_controller();
$units = read_units_controller();
$statuses = read_status_controller();
$restocks = read_restock_history_controller();
$adjustments = read_stock_adjustment_controller();

$productLabels = [];
$productStocks = [];

$availableCount = 0;
$outOfStockCount = 0;

foreach ($products as $p) {
    $stock = $p['total_stock'] ?? 0;
    $productLabels[] = $p['product_name'];
    $productStocks[] = $stock;

    $stock > 0 ? $availableCount++ : $outOfStockCount++;
}

$categoryStats = get_category_product_count();

$categoryLabels = [];
$categoryValues = [];

foreach ($categoryStats as $c) {
    $categoryLabels[] = $c['category_name'];
    $categoryValues[] = (int)$c['total_product'];
}
?>

<!DOCTYPE html>
<html>
<head>
   <title>Admin Dashboard</title>
   <!-- Emoji -->
   <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

   <!-- CSS -->
   <link rel="stylesheet" href="../../assets/css/dashboard.css">

   <!-- JS -->
   <script src="../../assets/js/dashboard.js" async></script>

   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
   <script>
      const productLabels = <?= json_encode($productLabels) ?>;
      const productStocks = <?= json_encode($productStocks) ?>;
      const availableCount = <?= $availableCount ?>;
      const outOfStockCount = <?= $outOfStockCount ?>;

      const categoryLabels = <?= json_encode($categoryLabels) ?>;
      const categoryValues = <?= json_encode($categoryValues) ?>;
   </script>

   <script src="../../assets/js/dashboard-chart.js"></script>

</head>
<body>

	<section id="content">
		<!-- NAVBAR -->
		<nav>
         <i class="bx bx-menu toggle-sidebar"></i>

         <form action="#">
            <div class="form-group">
               <input type="text" placeholder="Cari..">
            </div>
         </form>

         <span class="divider"></span>

         <div class="profile">
            <a href="../logout.php" class="logout-inline">
               LOG OUT
            </a>
            <a href = "../profile.php">
               <img src="../../assets/images/img-profile.jpg" alt="Profile">
            </a>
         </div>

      </nav>
		<!-- NAVBAR -->

      <!-- MAIN CONTENT -->
       <div class="main-content">
             <div id="dashboard-content" class="menu-content">
               <h1 class="main-title">Dashboard</h1>
            </div>
            
            <div class="dashboard-section">
               <h3>📊 Stok Produk</h3>
               <div class="chart-wrapper">
                  <canvas id="stockChart"></canvas>
               </div>
               
            </div>
            <div class="dashboard-section grid-2">
               <div class="chart-wrapper">
                  <h3>📦 Status Produk</h3>
                  <canvas id="statusChart"></canvas>
               </div>
               <div class="chart-wrapper">
                  <h3>🧩 Kategori Produk</h3>
                  <canvas id="categoryChart"></canvas>
               </div>
            </div>
       </div>
      <!-- MAIN CONTENT -->
	</section>

</body>
</html>
