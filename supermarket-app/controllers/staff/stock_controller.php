<?php
require_once(__DIR__ . '/../../models/stock_model.php');

// READ
function read_all_stocks_controller() {
  return get_all_stocks();
}

// CREATE 
function add_stock_controller($product_id, $supplier_id, $quantity, $unit_id) {
  return add_stock($product_id, $supplier_id, $quantity, $unit_id);
}

// UPDATE 
function remove_stock_controller($product_id, $supplier_id, $quantity, $unit_id) {
  return remove_stock($product_id, $supplier_id, $quantity, $unit_id);
}

// READ: restock history
function read_restock_history_controller() {
  return get_restock_history();
}

// READ: stock adjusment
function read_stock_adjustment_controller() {
  return get_stock_adjustment();
}
