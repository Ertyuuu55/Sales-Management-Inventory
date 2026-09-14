<?php
require_once(__DIR__ . '/../../models/user_model.php');

// CREATE
function create_user_controller($username, $password, $role_id) {
    return insert_user($username, $password, $role_id);
}

// READ
function read_users_controller() {
    return get_all_users();
}

// READ by ID
function read_user_by_id_controller($user_id) {
    return get_user_by_id($user_id);
}

// UPDATE
function update_user_controller($user_id, $username, $password, $role_id) {
    return update_user($user_id, $username, $password, $role_id);
}

// DELETE
function delete_user_controller($user_id) {
    return delete_user($user_id);
}

function get_user_by_id_controller($user_id) {
    global $conn;

    $query = "SELECT username, password, created_at 
              FROM users 
              WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

