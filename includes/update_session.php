<?php
session_start();

foreach ($_POST as $key => $value) {
    if (!empty($_POST)) {
        
        // Update the session variable
        $_SESSION[$key] = $value;
        echo json_encode(['status' => 'success']);
    } else {
        // Respond with an error if no data is POSTed
        echo json_encode(['status' => 'error', 'message' => 'No data received']);
    }
}
