<?php

session_start(); // Start the session

if (!empty($_POST)) {
  foreach ($_POST as $key => $value) {
    $_SESSION[$key] = $value;
  }
  echo "Session variables set!";
} else {
  echo "No data received.";
}
?>
