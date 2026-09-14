<?php
require_once(__DIR__ . '/../../models/supplier_model.php');

// CREATE
function create_supplier_controller($supplier_name, $supplier_address, $supplier_phoneNum) {
  return insert_supplier($supplier_name, $supplier_address, $supplier_phoneNum);
}

// READ
function read_suppliers_controller() {
  return get_all_suppliers();
}

// READ by ID
function read_supplier_by_id_controller($supplier_id) {
  return get_supplier_by_id($supplier_id);
}

// UPDATE
function update_supplier_controller($supplier_id, $supplier_name, $supplier_address, $supplier_phoneNum) {
  return update_supplier($supplier_id, $supplier_name, $supplier_address, $supplier_phoneNum);
}

// DELETE
function delete_supplier_controller($supplier_id) {
  return delete_supplier($supplier_id);
}
