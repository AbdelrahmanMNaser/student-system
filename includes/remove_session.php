<?php
session_start();
if (isset($_POST['removeKey'])) {
  $key = $_POST['removeKey'];

  // Remove the session variable
  unset($_SESSION[$key]);
  echo json_encode(['status' => 'success']);
} else {
  // Respond with an error if no data is POSTed
  echo json_encode(['status' => 'error', 'message' => 'No data received']);
}

?>