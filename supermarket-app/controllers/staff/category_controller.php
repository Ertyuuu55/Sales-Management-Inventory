<?php
require_once(__DIR__ . '/../../models/category_model.php');

// CREATE
function create_category_controller($category_name) {
  return insert_category($category_name);
}

// READ
function read_categories_controller() {
  return get_all_categories();
}

// READ by ID
function read_category_by_id_controller($category_id) {
  return get_category_by_id($category_id);
}

// UPDATE
function update_category_controller($category_id, $category_name) {
  return update_category($category_id, $category_name);
}

// DELETE
function delete_category_controller($category_id) {
  return delete_category($category_id);
}

function get_category_product_count() {
    global $conn;

    $query = "
        SELECT 
            c.category_name,
            COUNT(p.product_id) AS total_product
        FROM category c
        LEFT JOIN product p ON p.category_id = c.category_id
        GROUP BY c.category_id
    ";

    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}