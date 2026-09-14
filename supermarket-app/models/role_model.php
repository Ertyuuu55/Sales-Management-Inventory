<?php
require_once(__DIR__ . '/../config/db.php');

// get all role
function get_all_roles() {
  global $conn;
  $query = "SELECT * FROM roles ORDER BY role_id ASC";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// insert role
function insert_role($role_name) {
  global $conn;
  $created_at = date('Y-m-d H:i:s');
  $query = "INSERT INTO roles (role_name, created_at) VALUES (?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "ss", $role_name, $created_at);
  return mysqli_stmt_execute($stmt);
}

// get role by ID
function get_role_by_id($role_id) {
  global $conn;
  $query = "SELECT * FROM roles WHERE role_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $role_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_assoc($result);
}

// update role
function update_role($role_id, $role_name) {
  global $conn;
  $query = "UPDATE roles SET role_name = ? WHERE role_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "si", $role_name, $role_id);
  return mysqli_stmt_execute($stmt);
}

// delete role
function delete_role($role_id) {
  global $conn;
  
  // cek apakah role dipakai user
  $check = mysqli_prepare($conn, "SELECT COUNT(*) FROM users WHERE role_id = ?");
  mysqli_stmt_bind_param($check, "i", $role_id);
  mysqli_stmt_execute($check);
  $result = mysqli_stmt_get_result($check);
  $count = mysqli_fetch_row($result)[0];

  if ($count > 0) {
    return false; 
  }

  $query = "DELETE FROM roles WHERE role_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $role_id);
  return mysqli_stmt_execute($stmt);
}


