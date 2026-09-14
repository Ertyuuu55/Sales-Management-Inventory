<?php
require_once('../../../controllers/staff/product_controller.php');

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    delete_product_controller($product_id);
    header("Location: ../dashboard.php");
    exit;
} else {
    echo "ID produk tidak ditemukan.";
}
