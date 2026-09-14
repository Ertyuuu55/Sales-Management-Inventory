<?php
require_once(__DIR__ . '/../../models/status_model.php');

// READ 
function read_status_controller() {
    return get_all_status();
}
