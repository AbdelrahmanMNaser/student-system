<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assessment</title>

  <script src="/assets/js/jquery-3.7.1.min.js"></script>
</head>

<body>
  <?php
  define('INCLUDE_PATH', '/../../../includes/');
  define('NAV_PATH', '/../');

  include(__DIR__ . INCLUDE_PATH . 'identity_nav.php');
  include(__DIR__ . NAV_PATH . 'menu_nav.html');
  include(__DIR__ . INCLUDE_PATH . "print_data_input.php");
  ?>

  <main class="mx-auto grades min-vh-100 text-center py-5 px-3" id="courses">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">Assessment</h2>
    </header>
    <div class="d-flex align-items-center justify-content-center">

      <div class="row mb-3">

        <div class="col-md-6">
          <form action="" method="post">
            <select name="semester" id="semester" class="form-select" onchange="this.form.submit()">
              <option value="" disabled selected>Select Semester</option>
              <?php print_semesters("teaching", "professor"); ?>
            </select>
          </form>
        </div>

        <div class="col-md-6">
          <form action="" id="search" method="post">
            <select class="form-select" name="course" id="course" required>
              <option value="" disabled selected>Select Course</option>
              <?php print_courses("teaching", "professor"); ?>
            </select>
        </div>
        <div class="mb-3">
          <input type="submit" name="search_assessment" value="Search" class="btn btn-primary mt-4" onclick="submitFormAndRedirect();">
        </div>

      </div>
    </div>
  </main>
  <script src="/assets/js/save_select.js"></script>

  <script>
    handleDataUpdate('semester');
  </script>

  <script src="/assets/js/search_assessment.js"></script>
</body>

</html>
<?php
if (isset($_POST["search_assessment"])) {

  $course_id = $_POST["course"];

  $retrieve = "SELECT course.name As crs_name FROM course WHERE course.id= '$course_id' ";
  $result = $conn->query($retrieve);

  $course_name = $result->fetch_assoc()["crs_name"];

  $_SESSION["choosen_course_id"] = $course_id;
  $_SESSION["choosen_course_name"] = $course_name;
}

?>