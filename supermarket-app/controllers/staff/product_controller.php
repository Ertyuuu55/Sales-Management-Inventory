<?php
require_once(__DIR__ . '/../../models/product_model.php');

// CREATE
function insert_product_controller($product_name, $brand_id, $category_id, $supplier_id, $unit_id) {
    return insert_product($product_name, $brand_id, $category_id, $supplier_id, $unit_id);
}

// READ
function read_product_controller() {
    return get_all_products();
}

// READ by ID
function read_product_by_id_controller($product_id) {
    return get_product_by_id($product_id);
}

// UPDATE 
function update_product_controller($product_id, $product_name, $brand_id, $category_id, $supplier_id, $status_id = null){
    return update_product($product_id, $product_name, $brand_id, $category_id, $supplier_id, $status_id);
}

// DELETE
function delete_product_controller($product_id) {
    return delete_product($product_id);
}