<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schedule - Add</title>

  <script src="/assets/js/jquery-3.7.1.min.js"></script>

</head>

<body>
  <?php
  define('INCLUDE_PATH', '/../../../includes/');
  define('NAV_PATH', '/../');

  include(__DIR__ . INCLUDE_PATH . 'identity_nav.php');
  include(__DIR__ . NAV_PATH . 'menu_nav.html');
  include(__DIR__ . INCLUDE_PATH . 'alerts.php');
  include(__DIR__ . INCLUDE_PATH . 'print_data_input.php');
  ?>

  <main class="mx-auto grades text-center min-vh-100 py-5 px-3">

    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">Add Schedule</h2>
    </header>

    <div class="container">
      <div class="row align-items-center justify-content-center">

        <form action="" id="schedule_form" class="form-group col-md-6 bg-dark text-white p-5 rounded" method="post">

          <div class="row mb-3">
            <label for="course" class="form-label">Course</label>
            <select name="course" id="course" class="form-select text-center" onchange="this.form.submit()">
              <option value="" disabled selected>select course</option>
              <?php
              print_courses("teaching", "admin");
              ?>
            </select>
          </div>

          <div class="row mb-3">

            <div class="col">
              <label for="activity" class="form-label">Activity</label>
              <select name="activity" id="activity" class="form-select text-center" onchange="this.form.submit()">
                <option value="" disabled selected>select activity</option>
                <option value="Lecture">Lecture</option>


              </select>
            </div>

            <?php
            switch ($_SESSION["activity"]):
              case "Lecture":
            ?>

                <div class="col">
                  <label for="professor" class="form-label">Professor Name</label>
                  <select name="professor" id="professor" class="form-select">
                    <option value="" disabled selected>select professor</option>
                    <?php
                    $retrieve = "SELECT 
                              professor.id,
                              professor.first_name as prof_fname,
                              professor.last_name as prof_lname

                              FROM
                                 professor, teaching

                              WHERE
                                  teaching.professor_id = professor.id
                              AND teaching.semester_id = '$_SESSION[current_semester_id]'
                              AND teaching.course_id = '$_SESSION[course]'
                              ";
                    $result = $conn->query($retrieve);
                    while ($row = $result->fetch_assoc()) :
                      $prof_id = $row["id"];
                      $prof_full_name = $row["prof_fname"] . " " . $row["prof_lname"];
                    ?>
                      <option value="<?php echo $prof_id ?>"><?php echo $prof_full_name ?></option>
                    <?php endwhile ?>
                  </select>
                </div>

              <?php
                break;

              default:
              ?>

            <?php break;
            endswitch ?>

          </div>

          <div class="row mb-3">

            <div class="col">
              <label for="building" class="form-label">Building:</label>
              <select name="building_id" id="building" class="form-select " onchange="this.form.submit()">
                <option value="" disabled selected>Select building</option>
                <?php
                $retrieve = "SELECT * FROM building";
                $result = $conn->query($retrieve);

                $lastLoc = null;
                while ($row = $result->fetch_assoc()) {
                  $id = $row["id"];
                  $name = $row["name"];
                  $location = $row["location"];

                  if ($lastLoc != $location) {
                    if ($lastLoc != null) {
                      echo "</optgroup>";
                    }

                    echo "<optgroup label='$location'>";
                    $lastLoc = $location;
                  }

                  echo "<option value='$id'>$name</option>";
                }
                if ($lastLoc != null) {
                  echo "</optgroup>";
                }
                ?>
              </select>
            </div>


            <div class="col">
              <label for="room" class="form-label">Room:</label>
              <select name="room" id="room" class="form-select">
                <option value="" disabled selected>select room</option>

                <?php
                $building = $_SESSION['building'];

                $retrieve = "SELECT *
                  FROM room
                  WHERE `building_id` = '$building'";


                $result = $conn->query($retrieve);

                $lastType = null;
                while ($row = $result->fetch_assoc()) {
                  $id = $row["room_id"];
                  $type = $row["type"];
                  $capacity = $row["capacity"];

                  if ($lastType != $type) {
                    if ($lastType != null) {
                      echo "</optgroup>";
                    }

                    echo "<optgroup label='$type'>";
                    $lastType = $type;
                  }
                  echo "<option value='$id'>$name</option>";
                }
                if ($lastType != null) {
                  echo "</optgroup>";
                }
                ?>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <?php
            switch ($_SESSION["activity"]):
              case "Lecture":
              case "Section":
            ?>
                <label for="day" class="form-label">Day</label>
                <select name="day" id="day" class="form-control text-center">
                  <option value="" disabled selected>select day</option>
                  <option value="Saturday">Saturday</option>
                  <option value="Sunday">Sunday</option>
                  <option value="Monday">Monday</option>
                  <option value="Tuesuday">Tuesuday</option>
                  <option value="Wednesday">Wednesday</option>
                  <option value="Thursday">Thursday</option>
                  <option value="Friday">Friday</option>
                </select>

              <?php
                break;
              default:
              ?>
                <label for="date" class="form-label">Due Date</label>
                <input type="date" name="date" id="day" class="form-control text-center">

            <?php
                break;
            endswitch ?>
          </div>

          <div class="row mb-3">

            <div class="col">
              <label for="start_time" class="form-label">Start Time</label>
              <input type="time" name="start_time" id="start_time" class="form-control">
            </div>

            <div class="col">
              <label for="end_time" class="form-label">End Time</label>
              <input type="time" name="end_time" id="end_time" class="form-control">
            </div>

          </div>
          <input class="btn btn-primary mt-4" type="submit" value="Add Schedule" name="new_schedule" id="new_schedule">
        </form>
      </div>
    </div>
  </main>

  <script src="/assets/js/save_select.js"></script>
  <script src="/assets/js/delete_select.js"></script>
  <script>
    handleDataUpdate("course");
    handleDataUpdate("activity");
    handleDataUpdate("professor");
    handleDataUpdate("building");
  </script>

  <script>
    var formId = "schedule_form";
    var keys = ["course", "activity", "professor", "building"];
    handleDataRemoval(formId, keys);
  </script>


</body>

</html>

<?php

if (isset($_POST["new_schedule"])) {

  $semester_id = $_SESSION["current_semester_id"];

  $activity = $_POST["activity"];
  $course_id = $_POST["course"];
  $building_id = $_POST["building"];
  $room_id = $_POST["room"];
  $start_time = $_POST["start_time"];
  $end_time = $_POST["end_time"];

  if ($activity == "Lecture") {
    $prof_id = $_POST["professor"];
    $week_day = $_POST["day"];

    $insert_query = "INSERT INTO
        lecture_schedule(
          building_id,
          room_no,
          course_id,
          professor_id,
          semester_id,
          week_day,
          start_time,
          end_time
        )
        VALUES(
          '$building_id',
          '$room_no',
          '$course_id',
          '$prof_id',
          '$semester_id',
          '$week_day',
          '$start_time',
          '$end_time'
        )
        ";
    $insert = $conn->query($insert_query);
  } else {
    $due_date = $_POST["date"];

    $retrieve = "SELECT assess_id AS id
    FROM assessment 
    WHERE 
          type = '$activity' 
      AND semester_id = '$semester_id' 
      AND course_id = '$course_id'
    ";
    $result = $conn->query($retrieve);

    print_r($retrieve);

    $assess_id = $result->fetch_assoc()["id"];

    $insert_query = "UPDATE 
                      assessment_onsite_schedule 
                     SET 
                      room_id = '$room_id',
                      due_date = '$due_date', 
                      start_time = '$start_time', 
                      end_time = '$end_time'
                     WHERE 
                      assessment_id = '$assess_id'
    ";

    print_r($insert_query);

    $insert = $conn->query($insert_query);
  }
}

?>