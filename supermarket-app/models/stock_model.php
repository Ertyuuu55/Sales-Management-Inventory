<?php
require_once(__DIR__ . '/../config/db.php');

// get all stocks
function get_all_stocks() {
  global $conn;
  $query = "
    SELECT p.product_id, p.product_name, p.supplier_id,
           COALESCE(ts.total_stock, 0) AS total_stock,
           ts.unit_id, ts.last_updated_at,
           u.unit_name, s.supplier_name
    FROM product p
    LEFT JOIN total_stock ts ON p.product_id = ts.product_id
    LEFT JOIN qty_unit u ON ts.unit_id = u.unit_id
    JOIN supplier s ON p.supplier_id = s.supplier_id
    ORDER BY p.product_id ASC
  ";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// add stock
function add_stock($product_id, $supplier_id, $quantity, $unit_id) {
    global $conn;

    $stmt = $conn->prepare("UPDATE total_stock SET total_stock = total_stock + ? WHERE product_id = ?");
    $stmt->bind_param("ii", $quantity, $product_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO restock_history (product_id, supplier_id, quantity_change, unit_id, log_date) 
                            VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiii", $product_id, $supplier_id, $quantity, $unit_id);
    $stmt->execute();
    $stmt->close();
}


// remove stock
function remove_stock($product_id, $supplier_id, $quantity, $unit_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT total_stock FROM total_stock WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $current = $result->fetch_assoc();
    $stmt->close();

    if ($current['total_stock'] < $quantity) {
        echo "<script>alert('Stok tidak cukup untuk dikurangi!'); window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("UPDATE total_stock SET total_stock = total_stock - ? WHERE product_id = ?");
    $stmt->bind_param("ii", $quantity, $product_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO stock_adjustment (product_id, supplier_id, quantity_removed, unit_id, log_date) 
                            VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiii", $product_id, $supplier_id, $quantity, $unit_id);
    $stmt->execute();
    $stmt->close();
}

// get data restock history
function get_restock_history() {
  global $conn;
  $query = "
    SELECT rh.*, p.product_name, s.supplier_name, u.unit_name
    FROM restock_history rh
    JOIN product p ON rh.product_id = p.product_id
    JOIN supplier s ON rh.supplier_id = s.supplier_id
    JOIN qty_unit u ON rh.unit_id = u.unit_id
    ORDER BY rh.log_date DESC
  ";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// get data stok adjustment
function get_stock_adjustment() {
  global $conn;
  $query = "
    SELECT sa.*, p.product_name, s.supplier_name, u.unit_name
    FROM stock_adjustment sa
    JOIN product p ON sa.product_id = p.product_id
    JOIN supplier s ON sa.supplier_id = s.supplier_id
    JOIN qty_unit u ON sa.unit_id = u.unit_id
    ORDER BY sa.log_date DESC
  ";
  $result = mysqli_query($conn, $query);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
