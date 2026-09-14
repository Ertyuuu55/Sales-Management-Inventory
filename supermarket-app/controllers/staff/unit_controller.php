<?php
require_once(__DIR__ . '/../../models/unit_model.php');

// READ
function read_units_controller() {
  return get_all_units();
}

// READ by ID
function read_unit_by_id_controller($unit_id) {
  return get_unit_by_id($unit_id);
}