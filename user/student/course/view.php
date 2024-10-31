<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Course - View</title>
  <script src="/assets/js/jquery-3.7.1.min.js"></script>

</head>

<body>
  <?php
  define('INCLUDE_PATH', '/../../../includes/');
  define('NAV_PATH', '/../');
  define("JS_PATH", "../../assets/js/");

  include(__DIR__ . INCLUDE_PATH . 'identity_nav.php');
  include(__DIR__ . NAV_PATH . 'menu_nav.html');
  include(__DIR__ . INCLUDE_PATH . "print_data_input.php");
  ?>

  <main class="mx-auto crs view min-vh-100 text-center py-5 " id="courses">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold">VIEW COURSES</h2>

    </header>

    <form action="" id="course_view" method="post">
      <select class="form-select w-15 mx-auto mb-4" id="semester" name="semester" onchange="this.form.submit()">
        <option value="" disabled selected>Select Semester</option>
        <?php
        print_semesters("enrollment", "student");
        ?>
      </select>
    </form>

    <table class="table table-bordered">
      <thead>

        <th>Course Code</th>
        <th>Course Name</th>
        <th>Credits</th>
        <th>Pre-requisite(s)</th>
        <th>Professor(s) Name(s)</th>
        <th>Description</th>

      </thead>
      <tbody>

        <?php

        if (isset($_POST["semester"])) {
          $_SESSION["semester"] = $_POST["semester"];
        }

        $choosen_semester = $_SESSION["semester"];

        $retrieve = "SELECT 
          c1.name AS course_name, 
          c1.id AS course_id, 
          c1.credit AS course_credits, 
          c1.description as course_description,
          GROUP_CONCAT(DISTINCT c2.name SEPARATOR ', ') AS pre_requisite_names,
          GROUP_CONCAT(DISTINCT CONCAT(professor.first_name, ' ', professor.last_name) SEPARATOR ', ') AS professor_names
      
      FROM 
          course c1
      LEFT JOIN course_pre_requisit cp ON c1.id = cp.course_id
      LEFT JOIN course c2 ON cp.pre_requisit_id = c2.id
      LEFT JOIN enrollment ON c1.id = enrollment.course_id
      LEFT JOIN teaching ON c1.id = teaching.course_id
      LEFT JOIN professor ON teaching.professor_id = professor.id
      
      WHERE
          enrollment.student_id = '$_SESSION[id]'
      AND enrollment.semester_id = $choosen_semester
      
      GROUP BY
          c1.id
      ";

        $result = $conn->query($retrieve);
        while ($row = $result->fetch_assoc()) :
          $course_code = $row["course_id"];
          $course_name = $row["course_name"];
          $course_description = $row["course_description"];
          $course_credits = $row["course_credits"];
          $pre_requisites = $row["pre_requisite_names"];
          $professor_names = $row["professor_names"];
        ?>
          <tr>
            <td><?php echo $course_code ?></td>
            <td>
              <a href="view-details.php" class="course-link" data-course-name="<?php echo $course_name ?>" data-course-id="<?php echo $course_code ?>">
                <?php echo $course_name ?>
              </a>
            </td>
            <td><?php echo $course_credits ?></td>
            <td><?php echo $pre_requisites ?></td>
            <td><?php echo $professor_names ?></td>
            <td><?php echo $course_description ?></td>
          </tr>

        <?php endwhile ?>

      </tbody>

    </table>

  </main>

  <script src="<? echo __DIR__ . JS_PATH ?>save_select.js"></script>
  <script>
    handleDataUpdate("semester");
  </script>

  <script src="/assets/js/click_save_load.js"></script>

  <script>
    handleCourseLinkClick('.course-link');
  </script>

  <script>
    var app = angular.module('myApp', []);
    app.controller('myCtrl', function($scope) {

    });
  </script>

</body>

</html>

<?php
if (isset($_POST["course_id"]) && isset($_POST["course_name"])) {
  $_SESSION["choosen_course_id"] = $_POST["course_id"];
  $_SESSION["choosen_course_name"] = $_POST["course_name"];
}

?>