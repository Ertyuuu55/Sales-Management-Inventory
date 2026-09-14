<?php
require_once(__DIR__ . '/../config/db.php');

// get all categories
function get_all_categories() {
  global $conn;
  $query = "SELECT * FROM category ORDER BY category_id ASC";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// insert category
function insert_category($category_name) {
  global $conn;
  $query = "INSERT INTO category (category_name) VALUES (?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "s", $category_name);
  return mysqli_stmt_execute($stmt);
}

// get category by ID
function get_category_by_id($category_id) {
  global $conn;
  $query = "SELECT * FROM category WHERE category_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $category_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_assoc($result);
}

// update category
function update_category($category_id, $category_name) {
  global $conn;
  $query = "UPDATE category SET category_name = ? WHERE category_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "si", $category_name, $category_id);
  return mysqli_stmt_execute($stmt);
}

// delete category
function delete_category($category_id) {
  global $conn;

  $check = mysqli_prepare($conn, "SELECT COUNT(*) FROM product WHERE category_id = ?");
  mysqli_stmt_bind_param($check, "i", $category_id);
  mysqli_stmt_execute($check);
  $result = mysqli_stmt_get_result($check);
  $count = mysqli_fetch_row($result)[0];

  if ($count > 0) {
    return false; 
  }

  $query = "DELETE FROM category WHERE category_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $category_id);
  return mysqli_stmt_execute($stmt);
}