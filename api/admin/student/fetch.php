<?php
include("../../../includes/db_connection.php");
include("../../../includes/scores_grades.php");

$retrieve = "SELECT 
              student.*,
              (DATE_FORMAT(FROM_DAYS(DATEDIFF(now(), student.birth_date)), '%Y')+0) AS age, 
              department.name AS dept_name, 
              GROUP_CONCAT(student_phone.phone_number SEPARATOR ' | ') AS phone
            FROM 
              student
            LEFT JOIN 
              student_phone ON student.id = student_phone.student_id
            INNER JOIN 
              department ON student.department_id = department.id
            GROUP BY 
              student.id
            ";

$result = $conn->query($retrieve);

$records = array();

while ($row = $result->fetch_assoc()) {
  $records[] = array(
    "id" => $row["id"],
    "first_name" => $row["first_name"],
    "last_name" => $row["last_name"],
    "birth" => $row["birth_date"],
    "age" => $row["age"],
    "gender" => $row["gender"],
    "city" => $row["city"],
    "street" => $row["street"],
    "email" => $row["email"],
    "phone" => $row["phone"],
    "department" => $row["dept_name"],
    "register_date" => $row["registration_date"],
    "level" => calculate_student_level(calculate_total_credits($row["id"]))
  );
}

echo json_encode($records);
