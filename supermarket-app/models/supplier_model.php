<?php
require_once(__DIR__ . '/../config/db.php');

// get all suppliers
function get_all_suppliers() {
  global $conn;
  $query = "SELECT * FROM supplier ORDER BY supplier_id ASC";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// insert supplier
function insert_supplier($supplier_name, $supplier_address, $supplier_phoneNum) {
  global $conn;
  $query = "INSERT INTO supplier (supplier_name, supplier_address, supplier_phoneNum) VALUES (?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "sss", $supplier_name, $supplier_address, $supplier_phoneNum);
  return mysqli_stmt_execute($stmt);
}

// get supplier by ID
function get_supplier_by_id($supplier_id) {
  global $conn;
  $query = "SELECT * FROM supplier WHERE supplier_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $supplier_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_assoc($result);
}

// update supplier
function update_supplier($supplier_id, $supplier_name, $supplier_address, $supplier_phoneNum) {
  global $conn;
  $query = "UPDATE supplier 
            SET supplier_name = ?, supplier_address = ?, supplier_phoneNum = ? 
            WHERE supplier_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "sssi", $supplier_name, $supplier_address, $supplier_phoneNum, $supplier_id);
  return mysqli_stmt_execute($stmt);
}

// delete supplier
function delete_supplier($supplier_id) {
  global $conn;

  $check = mysqli_prepare($conn, "SELECT COUNT(*) FROM product WHERE supplier_id = ?");
  mysqli_stmt_bind_param($check, "i", $supplier_id);
  mysqli_stmt_execute($check);
  $result = mysqli_stmt_get_result($check);
  $count = mysqli_fetch_row($result)[0];

  if ($count > 0) {
    return false; 
  }

  $query = "DELETE FROM supplier WHERE supplier_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $supplier_id);
  return mysqli_stmt_execute($stmt);
}
