<?php
require_once(__DIR__ . '/../config/db.php');

// get all brand
function get_all_brands() {
  global $conn;
  $query = "SELECT * FROM brand ORDER BY brand_id ASC";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// insert brand
function insert_brand($brand_name) {
  global $conn;
  $query = "INSERT INTO brand (brand_name) VALUES (?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "s", $brand_name);
  return mysqli_stmt_execute($stmt);
}

// get brand by ID
function get_brand_by_id($brand_id) {
  global $conn;
  $query = "SELECT * FROM brand WHERE brand_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $brand_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_assoc($result);
}

// update brand
function update_brand($brand_id, $brand_name) {
  global $conn;
  $query = "UPDATE brand SET brand_name = ? WHERE brand_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "si", $brand_name, $brand_id);
  return mysqli_stmt_execute($stmt);
}

// delete brand
function delete_brand($brand_id) {
  global $conn;
  
  // cek apakah role dipakai user
  $check = mysqli_prepare($conn, "SELECT COUNT(*) FROM product WHERE brand_id = ?");
  mysqli_stmt_bind_param($check, "i", $brand_id);
  mysqli_stmt_execute($check);
  $result = mysqli_stmt_get_result($check);
  $count = mysqli_fetch_row($result)[0];

  if ($count > 0) {
    return false; 
  }

  $query = "DELETE FROM brand WHERE brand_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $brand_id);
  return mysqli_stmt_execute($stmt);
}
