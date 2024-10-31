<?php
function print_semesters($function, $role)
{
  global $conn;

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

  $result = $conn->query($retrieve);

  $lastYear = null;

  while ($row = $result->fetch_assoc()) {
    $id = $row["id"];
    $year = $row["year"];
    $semester = $row["semester"];

    if ($lastYear != $year) {

      if ($lastYear != null) {
        echo "</optgroup>";
      }

      echo "<optgroup label='$year'>";
      $lastYear = $year;
    }

    echo "<option value='$id'>$semester</option>";
  }

  if ($lastYear != null) {
    echo "</optgroup>";
  }
}

function print_courses($function, $role)
{
  global $conn;

  $role_id = $role . "_id";

  $choosen_semester = $_SESSION["current_semester_id"];

  // Start building the query
  $retrieve = "SELECT DISTINCT course.id AS crs_id, course.name as crs_name 
    FROM course, $function 
    WHERE ";

  if ($role == 'professor') {

    if (isset($_POST["semester"])) {
      $_SESSION["semester"] = $_POST["semester"];    
      $choosen_semester = $_SESSION["semester"];
    }

    $retrieve = $retrieve . "$function.$role_id = $_SESSION[id] AND ";
  }

  // Continue building the query
  $retrieve = $retrieve . 
  "
    $function.course_id = course.id 
    AND $function.semester_id = $choosen_semester
    ";

  $result = $conn->query($retrieve);

  while ($row = $result->fetch_assoc()) {
    $course_id = $row["crs_id"];
    $course_name = $row["crs_name"];

    echo "<option value = '$course_id'>" . $course_name . "</option>";
  }
}

function print_header_choosenCourseSemester($color)
{
  global $conn;

  if ($color == "white") {
    echo '<header class="header-adj2 mb-5 text-white">';
    echo '<h2 class=" f-header fw-bold text-white">';
  } else {
    echo '<header class="header-adj2 mb-5">';
    echo '<h2 class=" f-header fw-bold">';
  }

  $retrieve = "SELECT semester.semester, semester.year FROM semester WHERE semester.id = '$_SESSION[semester]' ";
  $result = $conn->query($retrieve)->fetch_assoc();

  $semester = $result['semester'] . " " . $result['year'];

  echo $semester;
  echo "<br>";
  echo $_SESSION["choosen_course_name"];

  echo '</h2>';
  echo '</header>';
}


function print_score_input()
{
  $scoreField = '<input 
                        type="text"
                        style="width: 100px; border: 1px solid black;" 
                        class="form-control text-center" 
                        name="score" id="score" 
                        required
                    >';
  return $scoreField;
}

function print_edit_icon()
{
  $editIcon = "<i 
                  onclick='displayInput(this.parentNode)' 
                  style= 'margin-left: 20px;' 
                  class = 'fa fa-edit'
                >" .
    "</i>";
  return $editIcon;
}
