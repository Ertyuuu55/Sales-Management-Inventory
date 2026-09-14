<?php
require_once('../../../controllers/staff/category_controller.php');

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    delete_category_controller($category_id);
    header("Location: ../dashboard.php");
    exit;
} else {
    echo "ID kategori tidak ditemukan.";
}
