<?php
require_once('../../../controllers/staff/supplier_controller.php');

if (isset($_GET['id'])) {
    $supplier_id = $_GET['id'];

    delete_supplier_controller($supplier_id);
    header("Location: ../dashboard.php");
    exit;
} else {
    echo "ID supplier tidak ditemukan.";
}
