<?php
session_start();
require_once(__DIR__ . '/../../../controllers/staff/stock_controller.php');

$product_id  = $_POST['product_id'];
$quantity    = $_POST['quantity'];
$unit_id     = $_POST['unit_id'];
$supplier_id = $_POST['supplier_id'];

add_stock_controller($product_id, $supplier_id, $quantity, $unit_id);

header("Location: ../dashboard.php");
exit;
