<?php
require_once(__DIR__ . '/../../models/role_model.php');

// CREATE
function create_role_controller($role_name) {
  return insert_role($role_name);
}

// READ
function read_roles_controller() {
  return get_all_roles();
}

// READ by ID
function read_role_by_id_controller($role_id) {
  return get_role_by_id($role_id);
}

// UPDATE
function update_role_controller($role_id, $role_name) {
  return update_role($role_id, $role_name);
}

// DELETE
function delete_role_controller($role_id) {
  return delete_role($role_id);
}

