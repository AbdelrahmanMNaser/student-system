<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Schedule - Lectures</title>

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
      <h2 class=" f-header fs-1 text-white fw-bold">Lectures Schedule</h2>
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
          $choosen_semester = $_SESSION["semester"];
        }


        $retrieve = "SELECT 
        DISTINCT
            hall.building, 
            hall.location,
            lecture_schedule.*,
            course.name as crs_name
        
        FROM 
            hall,
            lecture_schedule,
            teaching,
            course,
            professor

        WHERE
               lecture_schedule.hall_no = hall.id
          AND  lecture_schedule.course_id = teaching.course_id          
          AND  lecture_schedule.professor_id = teaching.professor_id
          AND  lecture_schedule.semester_id = teaching.semester_id
          AND  teaching.course_id = course.id
          AND  teaching.professor_id = '$_SESSION[id]'
          AND  teaching.semester_id = $choosen_semester
    ";

        $result = $conn->query($retrieve);

        $day_courses_count = [];

        while ($row = $result->fetch_assoc()) {
          $day = $row['week_day'];

          // If the day is not set in the array, initialize it with 0
          if (!isset($day_courses_count[$day])) {
            $day_courses_count[$day] = 0;
          }

          $day_courses_count[$day]++;
        }

        // Reset the pointer to the beginning of the result set
        $result->data_seek(0);

        while ($row = $result->fetch_assoc()) :
          $day = $row['week_day'];
          $course = $row['crs_name'];
          $hall = $row['hall_no'];
          $building = $row['building'];
          $location = $row['location'];

          $start_time = $row['start_time'];
          $end_time = $row['end_time'];

          // Convert to 12-hour format with AM/PM
          $start_time = date("g:i A", strtotime($start_time));
          $end_time = date("g:i A", strtotime($end_time));


          // Check if we need to output the day and rowspan
          if ($day_courses_count[$day] > 0) {
            echo "<tr>";
            echo "<td rowspan='{$day_courses_count[$day]}'>" . "$day" . "</td>";
            $day_courses_count[$day] = 0; // Reset the count so we don't output rowspan again for this day
          } else {
            echo "<tr>";
          }

        ?>

          <td><?php echo $start_time; ?></td>
          <td><?php echo $end_time;  ?></td>
          <td><?php echo $course; ?></td>
          <td><?php echo $hall; ?></td>
          <td><?php echo $building; ?></td>
          <td><?php echo $location; ?></td>

          </tr>

        <?php
        endwhile
        ?>

      </tbody>
    </table>

    <script src="/assets/js/save_select.js"></script>
    <script>
      handleDataUpdate("semester");
    </script>


</body>

</html>