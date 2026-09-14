<?php
require_once('../../../controllers/staff/brand_controller.php');

if (isset($_GET['id'])) {
    $brand_id = $_GET['id'];

    delete_brand_controller($brand_id);
    header("Location: ../dashboard.php");
    exit;
} else {
    echo "ID brand tidak ditemukan.";
}
