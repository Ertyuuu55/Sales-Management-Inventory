<?php
require_once('../../../controllers/admin/user_controller.php');

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    delete_user_controller($user_id);

    header("Location: ../dashboard.php");
    exit;
} else {
    echo "ID user tidak ditemukan.";
}
