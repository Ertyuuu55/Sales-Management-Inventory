<?php
require_once(__DIR__ . '/../config/db.php');

// get all product
function get_all_products() {
  global $conn;
  $query = "
    SELECT p.product_id, p.product_name,
           b.brand_name,
           c.category_name,
           s.supplier_name,
           CASE 
             WHEN p.status_id = 4 THEN 'OTW'
             WHEN ts.total_stock > 50 THEN 'available'
             WHEN ts.total_stock > 0 THEN 'need restock'
             ELSE 'out of stock'
           END AS status_name,
           ts.total_stock,
           ts.last_updated_at
    FROM product p
    JOIN brand b ON p.brand_id = b.brand_id
    JOIN category c ON p.category_id = c.category_id
    JOIN supplier s ON p.supplier_id = s.supplier_id
    LEFT JOIN total_stock ts ON p.product_id = ts.product_id
    ORDER BY p.product_id ASC
  ";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// insert product (default status = out of stock)
// function insert_product($product_name, $brand_id, $category_id, $supplier_id) {
//   global $conn;
//   $default_status_id = 3;

//   // Insert ke tabel product
//   $query = "INSERT INTO product (product_name, brand_id, category_id, supplier_id, status_id) 
//             VALUES (?, ?, ?, ?, ?)";
//   $stmt = mysqli_prepare($conn, $query);
//   mysqli_stmt_bind_param($stmt, "siiii", $product_name, $brand_id, $category_id, $supplier_id, $default_status_id);
//   $success = mysqli_stmt_execute($stmt);

//   if ($success) {
//     $product_id = mysqli_insert_id($conn);

//     $default_unit_id = 1;
//     $stock_query = "INSERT INTO total_stock (product_id, total_stock, unit_id) VALUES (?, 0, ?)";
//     $stock_stmt = mysqli_prepare($conn, $stock_query);
//     mysqli_stmt_bind_param($stock_stmt, "ii", $product_id, $default_unit_id);
//     mysqli_stmt_execute($stock_stmt);
//   }

//   return $success;
// }
function insert_product($product_name, $brand_id, $category_id, $supplier_id, $unit_id) {
  global $conn;
  $default_status_id = 3;

  $query = "INSERT INTO product (product_name, brand_id, category_id, supplier_id, status_id) 
            VALUES (?, ?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "siiii", $product_name, $brand_id, $category_id, $supplier_id, $default_status_id);
  $success = mysqli_stmt_execute($stmt);

  if ($success) {
    $product_id = mysqli_insert_id($conn);

    $stock_query = "INSERT INTO total_stock (product_id, total_stock, unit_id) VALUES (?, 0, ?)";
    $stock_stmt = mysqli_prepare($conn, $stock_query);
    mysqli_stmt_bind_param($stock_stmt, "ii", $product_id, $unit_id);
    mysqli_stmt_execute($stock_stmt);
  }

  return $success;
}

// get product by ID
function get_product_by_id($product_id) {
  global $conn;
  $query = "
    SELECT p.product_id, p.product_name,
           p.brand_id, p.category_id, p.supplier_id,
           b.brand_name,
           c.category_name,
           s.supplier_name,
           CASE 
             WHEN p.status_id = 4 THEN 'OTW'
             WHEN ts.total_stock > 50 THEN 'available'
             WHEN ts.total_stock > 0 THEN 'need restock'
             ELSE 'out of stock'
           END AS status_name,
           ts.total_stock,
           ts.last_updated_at
    FROM product p
    JOIN brand b ON p.brand_id = b.brand_id
    JOIN category c ON p.category_id = c.category_id
    JOIN supplier s ON p.supplier_id = s.supplier_id
    LEFT JOIN total_stock ts ON p.product_id = ts.product_id
    WHERE p.product_id = ?
  ";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $product_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_assoc($result);
}

// update product 
function update_product($product_id, $product_name, $brand_id, $category_id, $supplier_id, $status_id = null) {
  global $conn;

  if ($status_id !== null) {
    $query = "UPDATE product 
              SET product_name = ?, brand_id = ?, category_id = ?, supplier_id = ?, status_id = ? 
              WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "siiiii", $product_name, $brand_id, $category_id, $supplier_id, $status_id, $product_id);
  } else {
    $query = "UPDATE product 
              SET product_name = ?, brand_id = ?, category_id = ?, supplier_id = ? 
              WHERE product_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "siiii", $product_name, $brand_id, $category_id, $supplier_id, $product_id);
  }

  return mysqli_stmt_execute($stmt);
}

// delete product
function delete_product($product_id) {
  global $conn;
  $query = "DELETE FROM product WHERE product_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $product_id);
  return mysqli_stmt_execute($stmt);
}
