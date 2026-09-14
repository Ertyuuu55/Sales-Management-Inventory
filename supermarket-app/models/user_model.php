<?php
require_once(__DIR__ . '/../config/db.php');

// get all user
function get_all_users() {
  global $conn;
  $query = "SELECT * FROM users ORDER BY user_id ASC";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// insert user
function insert_user($username, $password, $role_id) {
  global $conn;
  $created_at = date('Y-m-d H:i:s');
  $query = "INSERT INTO users (username, password, role_id, created_at) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "ssis", $username, $password, $role_id, $created_at);
  return mysqli_stmt_execute($stmt);
}

// get user by ID
function get_user_by_id($user_id) {
  global $conn;
  $query = "SELECT * FROM users WHERE user_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $user_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_assoc($result);
}

// update user
function update_user($user_id, $username, $password, $role_id) {
  global $conn;
  $query = "UPDATE users SET username = ?, password = ?, role_id = ? WHERE user_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "ssii", $username, $password, $role_id, $user_id);
  return mysqli_stmt_execute($stmt);
}

// delete user 
function delete_user($user_id) {
  global $conn;
  $query = "DELETE FROM users WHERE user_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $user_id);
  return mysqli_stmt_execute($stmt);
}