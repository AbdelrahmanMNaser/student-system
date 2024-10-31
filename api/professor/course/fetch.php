<?php
session_start();

require_once "../../../config/connection.php";

$choosen_semester = $_SESSION["semester"];

$retrieve = "SELECT
        DISTINCT
          course.id as crs_code,
          course.name as crs_name,
          COUNT(enrollment.student_id) as std_count
        FROM
          course, teaching, enrollment
        WHERE
              teaching.course_id = course.id
          AND teaching.course_id = enrollment.course_id
          AND teaching.semester_id = enrollment.semester_id
          AND teaching.semester_id = '$choosen_semester'
          AND teaching.professor_id = '{$_SESSION["id"]}'

        GROUP BY
          course.id
      ";

    $result = $conn->query($retrieve);

    $records = array();

    while ($row = $result->fetch_assoc()) {
        $records[] = array(
            "code" => $row["crs_code"],
            "name" => $row["crs_name"],
            "students_count" => $row["std_count"],
        );
    }

    echo json_encode($records); 

?>