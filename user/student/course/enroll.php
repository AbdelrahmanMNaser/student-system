<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Enroll Course</title>

</head>

<body>
  <?php
  define('INCLUDE_PATH', '/../../../includes/');
  define('NAV_PATH', '/../');

  include(__DIR__ . INCLUDE_PATH . 'identity_nav.php');
  include(__DIR__ . NAV_PATH . 'menu_nav.html');
  include(__DIR__ . INCLUDE_PATH . "scores_grades.php");
  ?>

  <main class="mx-auto crs enroll min-vh-100 text-center py-5 px-3" id="courses">
    <header class="header mb-5">
      <h2 class=" f-header fs-1 fw-bold">ENROLL COURSES</h2>
      <h3 style="color: aquamarine;">
        <?php echo $_SESSION["current_semester"] ?>
      </h3>


    </header>

    <form action="" method="post" id="courseForm">
      <label for="courseSelect" class="form-label fw-bold fs-5 mb-2">Select Course:</label>

      <select class="form-select w-15 mx-auto mb-4" name="course" id="courseSelect">
        <option value="" disabled selected>select course</option>
        <?php
        $student_id = $_SESSION["id"];

        $retrieve = "SELECT 
                      course_id, 
                      course.name as course_name 
                  FROM 
                      teaching
                  JOIN 
                      course ON teaching.course_id = course.id
                  JOIN 
                      professor ON teaching.professor_id = professor.id
                  JOIN 
                      student ON student.department_id = professor.department_id
                  WHERE 
                      teaching.course_id NOT IN (SELECT course_id FROM enrollment WHERE student_id = $student_id)
                      AND teaching.semester_id = '$_SESSION[current_semester_id]'
                      AND student.id = '$student_id'
            
                ";

        $result = $conn->query($retrieve);
        while ($row = $result->fetch_assoc()) {

          $course_id = $row['course_id'];
          $course_name = $row['course_name'];

          // Check if the course has any prerequisites
          $retrieve_pre = "SELECT pre_requisit_id FROM course_pre_requisit WHERE course_id = $course_id";
          $result_pre = $conn->query($retrieve_pre);

          if ($result_pre->num_rows > 0) {            // The course has prerequisites, check if the student has passed them all

            while ($row_pre = $result_pre->fetch_assoc()) {

              $pre_req_id = $row_pre['pre_req_id'];

              // Check if the student has enrolled in the prerequisite course
              $retrieve_enroll = "SELECT semester_id FROM enrollment WHERE student_id = $student_id AND course_id = $pre_req_id";
              $result_enroll = mysqli_query($conn, $retrieve_enroll);

              if ($result_enroll->num_rows > 0) {

                // The student has enrolled in the prerequisite course, check if they passed it
                $row_enroll = mysqli_fetch_assoc($result_enroll);
                $semester_id = $row_enroll['semester_id'];

                $total_score = calculate_total_score($student_id, $pre_req_id, $semester_id);

                if (calculate_grade($total_score) == 'F') {
                  $all_passed = false;
                  break;
                }
              } else {
                $all_passed = false;
                break;
              }
            }

            if ($all_passed) {
              // The student has passed all prerequisites, add the course to the select element
              echo "<option value='$course_id'>" . $course_name . "</option>";
            }
          } else {
            // The course has no prerequisites, add the course to the select element
            echo "<option value='$course_id'>" . $course_name . "</option>";
          }
        }


        ?>

      </select>


      <input type="submit" value="Add Course" name="add_course_semester" id="addButton" class="btn btn-primary">
    </form>

  </main>

</body>

</html>

<?php
if (isset($_POST["add_course_semester"])) {
  $course_id = $_POST["course"];

  $insert_query = "INSERT INTO
    enrollment (
        student_id,
        course_id,
        semester_id
    )
    VALUES (
        $student_id,
        $course_id,
        '$_SESSION[current_semester_id]'
    )
    ";


  $insert = $conn->query($insert_query);

  if ($insert) {
    echo "<div style='background-color: #DFF2BF; color: #4F8A10; padding: 10px; margin: 10px 0;'>Course Enrolled Successfully.</div>";
  } else {
    echo "<div style='background-color: #FFD2D2; color: #D8000C; padding: 10px; margin: 10px 0;'>database insertion failed.</div>";
  }
}
?>