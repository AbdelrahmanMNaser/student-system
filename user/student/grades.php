<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Grades</title>
  <script src="/assets/js/jquery-3.7.1.min.js"></script>

</head>

<body>
  <?php
  define('INCLUDE_PATH', '/../../includes/');
  define('NAV_PATH', '');

  include(__DIR__ . INCLUDE_PATH . 'identity_nav.php');
  include('menu_nav.html');
  include(__DIR__ . INCLUDE_PATH . "print_data_input.php");
  include(__DIR__ . INCLUDE_PATH . "scores_grades.php");
  ?>

  <main class="mx-auto grades min-vh-100 text-center py-5 px-3" id="courses">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">Grades</h2>
    </header>

    <form action="" id="course_view" method="post">
      <select class="form-select w-15 mx-auto mb-4" name="semester" id="semester" onchange="this.form.submit()">
        <option value="" disabled selected>Select Semester</option>
        <?php print_semesters('enrollment', 'student') ?>
      </select>

      <table class=" table table-bordered">
        <thead>
          <th>Course Code</th>
          <th>Course Name</th>
          <th>Credits</th>
          <th>Grade</th>
          <th></th>
        </thead>

        <?php
        if (isset($_POST["semester"])) {
          $_SESSION["semester"] = $_POST["semester"];
        }

        $choosen_semester = $_SESSION["semester"];

        $retrieve = "SELECT
            course.id as crs_code, 
            course.name as crs_name,
            course.credit as crs_credits

            FROM 
              course, enrollment
            WHERE 
                  enrollment.course_id = course.id
              AND enrollment.semester_id = $choosen_semester
          ";

        $result = $conn->query($retrieve);
        while ($row = $result->fetch_assoc()) :
          $course_code = $row["crs_code"];
          $course_name = $row["crs_name"];
          $course_credits = $row["crs_credits"];
          $grade = calculate_grade(calculate_total_score($_SESSION["id"], $course_code, $choosen_semester));
        ?>

          <tbody>
            <tr>
              <td><?php echo $course_code ?></td>
              <td><?php echo $course_name ?></td>
              <td><?php echo $course_credits ?></td>
              <td><?php echo $grade ?></td>
              <td>
                <a href="course/view-score.php" class="course-grades-link" data-course-name="<?php echo $course_name ?>" data-course-id="<?php echo $course_code ?>">Scores</a>
              </td>
            </tr>
          <?php endwhile ?>


          </tbody>
    </form>

    </table>


  </main>

  <script src="/assets/js/save_select.js"></script>
  <script>
    handleDataUpdate("semester");
  </script>

  <script src="/assets/js/click_save_load.js"></script>
  <script>
    handleCourseLinkClick('.course-grades-link');
  </script>

</body>

</html>

<?php
if (isset($_POST["course_id"]) && isset($_POST["course_name"])) {
  $_SESSION["choosen_course_id"] = $_POST["course_id"];
  $_SESSION["choosen_course_name"] = $_POST["course_name"];
}
?>