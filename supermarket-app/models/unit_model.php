<?php
require_once(__DIR__ . '/../config/db.php');

// get all unit
function get_all_units() {
  global $conn;
  $query = "SELECT * FROM qty_unit ORDER BY unit_id ASC";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// get unit by ID
function get_unit_by_id($unit_id) {
  global $conn;
  $query = "SELECT * FROM qty_unit WHERE unit_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $unit_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_assoc($result);
}