<?php
require_once(__DIR__ . '/../../models/brand_model.php');

// CREATE
function create_brand_controller($brand_name) {
  return insert_brand($brand_name);
}

// READ
function read_brand_controller() {
  return get_all_brands();
}

// READ by ID
function read_brand_by_id_controller($brand_id) {
  return get_brand_by_id($brand_id);
}

// UPDATE
function update_brand_controller($brand_id, $brand_name) {
  return update_brand($brand_id, $brand_name);
}

// DELETE
function delete_brand_controller($brand_id) {
  return delete_brand($brand_id);
}