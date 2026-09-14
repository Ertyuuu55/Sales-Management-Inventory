<?php
require_once(__DIR__ . '/../config/db.php');

// get all status
function get_all_status() {
    global $conn;
    $query = "SELECT status_id, status_name FROM status ORDER BY status_id ASC";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// get status by ID
function get_status_by_id($status_id) {
  global $conn;
  $query = "SELECT * FROM status WHERE status_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $status_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_assoc($result);
}