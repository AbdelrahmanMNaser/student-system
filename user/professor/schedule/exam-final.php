<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schedule - Final</title>

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

  <main class="mx-auto class min-vh-100 text-center py-5 px-3" id="courses">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 text-white fw-bold">Final Schedule</h2>
    </header>

    <form action="" id="course_view" method="post">
      <select class="form-select w-15 mx-auto mb-4" id="semester" name="semester" onchange="this.form.submit()">
        <option value="" disabled selected>Select Semester</option>
        <?php
        print_semesters("teaching", "professor");
        ?>
      </select>
    </form>

    <table class="table table-bordered">
      <thead>
        <th>Day</th>
        <th>Date</th>
        <th>Start time</th>
        <th>End time</th>
        <th>Course</th>
        <th>Hall</th>
        <th>Building</th>
        <th>Location</th>

      </thead>
      <tbody>
        <?php
        if (isset($_POST["semester"])) {
          $choosen_semester = $_POST["semester"];
        } else {
          $choosen_semester = $_SESSION["choosen_semester_id"];
        }


        $retrieve = "SELECT
              assessment_onsite_schedule.assessment_id,
              assessment_onsite_schedule.due_date,
              assessment_onsite_schedule.start_time,
              assessment_onsite_schedule.end_time,
              GROUP_CONCAT(DISTINCT assessment_onsite_schedule.room_id SEPARATOR ', ') AS halls, 
              GROUP_CONCAT(DISTINCT hall.building SEPARATOR ', ') as building,
              GROUP_CONCAT(DISTINCT hall.location SEPARATOR ', ') as location,
              course.name AS crs_name
            FROM 
              assessment_onsite_schedule, 
              assessment,
              hall, 
              course 
            WHERE 
                  assessment_onsite_schedule.assessment_id = assessment.assess_id
              AND assessment_onsite_schedule.room_id = hall.id
              AND assessment.course_id = course.id
              AND assessment.semester_id = $choosen_semester
              AND assessment.type = 'Final'
            GROUP BY 
              assessment_onsite_schedule.assessment_id, 
              assessment_onsite_schedule.due_date, 
              assessment_onsite_schedule.start_time, 
              assessment_onsite_schedule.end_time, 
              course.name
            ORDER BY
              assessment_onsite_schedule.due_date
    ";

        $result = $conn->query($retrieve);

        // Initialize an array to keep track of the number of courses/day
        $date_courses_count = [];

        while ($row = $result->fetch_assoc()) {
          $date = $row['due_date'];

          // If the date is not set in the array, initialize it with 0
          if (!isset($date_courses_count[$date])) {
            $date_courses_count[$date] = 0;
          }

          $date_courses_count[$date]++;
        }

        // Reset the pointer to the beginning of the result set
        $result->data_seek(0);

        while ($row = $result->fetch_assoc()) {
          $date = $row["due_date"];
          $day = date('l', strtotime($date));
          $course = $row['crs_name'];
          $hall = $row['halls'];
          $building = $row['building'];
          $location = $row['location'];

          $start_time = $row['start_time'];
          $end_time = $row['end_time'];

          // Convert to 12-hour format with AM/PM
          $start_time = date("g:i A", strtotime($start_time));
          $end_time = date("g:i A", strtotime($end_time));

          // Check if we need to output the day and rowspan
          if ($date_courses_count[$date] > 0) {
            echo "<tr>";
            echo "<td rowspan='{$date_courses_count[$date]}'>" . "$day" . "</td>";
            $date_courses_count[$date] = 0; // Reset the count so we don't output rowspan again for this day
          } else {
            echo "<tr>";
          }

        ?>
          <td><?php echo $date; ?> </td>
          <td><?php echo $start_time; ?></td>
          <td><?php echo $end_time;  ?></td>
          <td><?php echo $course; ?></td>
          <td><?php echo $hall; ?></td>
          <td><?php echo $building; ?></td>
          <td><?php echo $location; ?></td>

          </tr>

        <?php
        }
        ?>

      </tbody>
    </table>

    <script src="/assets/js/save_select.js"></script>
    <script>
      handleDataUpdate("semester");
    </script>

</body>

</html>