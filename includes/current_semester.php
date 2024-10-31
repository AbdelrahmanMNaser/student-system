<?php
function get_current_semester() {
  global $conn;

  $retrieve = "SELECT * 
  FROM semester 
  WHERE CURRENT_DATE() BETWEEN semester.start_date AND semester.end_date
  ";

  $result = $conn->query($retrieve)->fetch_assoc();

  $current_semester_id = $result["id"];
  $current_semester = $result["semester"] . " " . $result["year"];
  

  $_SESSION["current_semester_id"] = $current_semester_id;
  $_SESSION["current_semester"] = $current_semester;
}

?>