<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schedule - View</title>
  <script src="/assets/js/jquery-3.7.1.min.js"></script>
  <script src="/assets/js/save_select.js"></script>
</head>

<body>
  <?php
  define('INCLUDE_PATH', '/../../../includes/');
  define('NAV_PATH', '/../');

  include(__DIR__ . INCLUDE_PATH . 'identity_nav.php');
  include(__DIR__ . NAV_PATH . 'menu_nav.html');
  include(__DIR__ . INCLUDE_PATH . "print_data_input.php");
  ?>

  <main class="mx-auto admin text-center min-vh-100 py-5 px-3">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">View Schedule</h2>
    </header>

    <div class="d-flex align-items-center justify-content-center">
      <form action="" method="post">

        <div class="row mb-3">

          <div class="col">
            <select name="semester" id="semester" class="form-select" required>
              <option value="" disabled selected>Select Semester</option>
              <?php print_semesters("teaching", "admin"); ?>
            </select>
          </div>

          <div class="col">
            <select class="form-select" name="activity" id="activity" onchange="this.form.submit()" required>
              <option value="" disabled selected>Select Activity</option>
              <optgroup label="Class">
                <option value="Lecture">Lecture</option>
                <option value="Section">Section</option>
              </optgroup>
              <optgroup label="Coursework">
                <option value="Quiz">Quiz</option>
                <option value="Project">Project</option>
                <option value="Practical">Practical</option>
                <option value="Oral">Oral</option>
              </optgroup>
              <optgroup label="Exams">
                <option value="Midterm">Midterm</option>
                <option value="Final">Final</option>
              </optgroup>
            </select>
          </div>
      </form>
    </div>
    </div>

    <table class="table table-bordered text-center">
      <thead>
        <th>Day</th>
        <?php if (!($_SESSION["activity"] == "Lecture" || $_SESSION["activity"] == "Section")) : ?>
          <th>Due Date</th>
        <?php endif ?>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Location</th>
        <th>Building</th>

        <th>Course Name</th>
        <?php if ($_SESSION["activity"] == "Lecture") : ?>
          <th>Professor Name</th>
        <? endif ?>

      </thead>

      <tbody>
        <?php
        # create sql query to retrieve data from database
        # use the $_SESSION["activity"] to determine the category from assessment or lecture or section to retrieve data from
        # use the $_SESSION["semester"] to determine the semester 
        # given that there are following tables in the database
        # lecture_schedule (room_) , assessment, assessment_onsite_schedule
        # columns in the tables are as follows
        # lecture_schedule (week_day, start_time, end_time, hall_no, professor_id, course_id, semester_id)
        # assessment (assess_id course_id, semester_id, category (activity) , format)
        # assessment_onsite_schedule (assessment_id, due_date, start_time, end_time, room_id)
        # course (id, course_name, course_code)
        # professor (id, professor_name)
        # building (id, location, name)
        # room (room_id, building_id, location)
        # semester (id, semester_name)
        # i want retrieve either lecture schedule or assessment_onsite_schedule based on user selection



        ?>
      </tbody>

    </table>

  </main>
  <script>
    handleDataUpdate("semester");
    handleDataUpdate("activity");
  </script>
</body>

</html>