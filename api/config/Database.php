<?php
class Database {
  private $conn;

  public function __construct() {
      $connection = new mysqli('localhost', 'root', 'root', 'student_demo');
      $this->conn = $connection;

      $error = $connection->connect_error;
      if ($error) {
          die("Connection failed: " . $error);
      }
  }
  public function getConnection() {
      return $this->conn;
  }
}

?>