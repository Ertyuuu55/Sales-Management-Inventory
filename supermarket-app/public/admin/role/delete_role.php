<?php
require_once('../../../controllers/admin/role_controller.php');

if (isset($_GET['id'])) {
    $role_id = $_GET['id'];

    delete_role_controller($role_id);
    header("Location: ../dashboard.php");
    exit;
} else {
    echo "ID role tidak ditemukan.";
}
