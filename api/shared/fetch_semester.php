<?php
session_start();

class SemesterFetcher {
  private $conn;

  public function __construct($conn) {
    $this->conn = $conn;
  }

  public function fetch_semesters($function, $role) {
    $role_id = $role . "_id";

    $retrieve = "SELECT 
        DISTINCT
          semester.id AS id,
          semester.semester as semester,
          semester.year as year
        
        FROM
          semester, $function
      
        WHERE 
        ";

    if ($role == "professor" || $role == "student") {
      $retrieve = $retrieve . "$function.$role_id = $_SESSION[id] AND ";
    }

    $retrieve = $retrieve . "$function.semester_id = semester.id";

    $result = $this->conn->query($retrieve);

    $semesters = [];

    while ($row = $result->fetch_assoc()) {
      $semesters[] = $row;
    }

    return $semesters;
  }
}

$semesterFetcher = new SemesterFetcher($conn);
header('Content-Type: application/json');
echo json_encode($semesterFetcher->fetch_semesters($_GET['function'], $_GET['role']));
?>
