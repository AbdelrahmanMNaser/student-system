<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    <?php print_header_choosenCourseSemester("white") ?>

    <table class="table table-bordered">

      <?php

      $choosen_semester = $_SESSION["semester"];
      $choosen_course = $_SESSION["choosen_course_id"];

      $retrieve = "SELECT 
      student.id as std_id,
      student.first_name as std_fname,
      student.last_name as std_lname,
      Assessment.type, 
      Assessment_score.score
    FROM 
      student, Assessment, Assessment_score
    WHERE
        Assessment.semester_id = '$choosen_semester'
        AND Assessment.course_id = '$choosen_course'
        AND Assessment_score.Assessment_id = Assessment.assess_id
        AND Assessment_score.student_id = student.id
    ";
      $result = $conn->query($retrieve);

      // hold all the different types of assessments
      $assessment_types = [];

      // hold student data
      $students = [];

      while ($row = $result->fetch_assoc()) {

        $assessment_types[$row["type"]] = true;

        // Add the student's score for this assessment type
        $students[$row["std_id"]]["id"] = $row["std_id"];
        $students[$row["std_id"]]["name"] = $row["std_fname"] . " " . $row["std_lname"];
        $students[$row["std_id"]]["scores"][$row["type"]] = $row["score"];

        // get the sum of scores
        if (!isset($students[$row["std_id"]]["scores"]["Total"])) {
          $students[$row["std_id"]]["scores"]["Total"] = 0;
        }

        // get sum of scores
        $students[$row["std_id"]]["scores"]["Total"] += $row["score"];
      }

      if (isset($assessment_types["final"])) {
        // Remove "final" from its current position
        unset($assessment_types["final"]);

        // add it again
        $assessment_types["final"] = true;
      }

      // Add "Total" to the assessment types
      $assessment_types["Total"] = true;

      ?>

      <thead>
        <th>Student ID</th>
        <th>Student Name</th>

        <?php foreach (array_keys($assessment_types) as $type) {
        ?>
          <th><?php echo $type ?></th>;
        <?php } ?>

      </thead>

      <tbody>

        <?php

        foreach ($students as $student) { ?>
          <tr>
            <td><?php echo $student["id"] ?></td>
            <td><?php echo $student["name"] ?></td>

            <?php

            // Output scores for each assessment type, 
            foreach (array_keys($assessment_types) as $type) { ?>
              <td>
                <?php // if available 
                if (isset($student["scores"][$type])) {
                  echo $student["scores"][$type];
                }
                ?>
              </td>
            <?php
            }
            ?>

          </tr>
        <?php
        }
        ?>


      </tbody>
    </table>

  </main>

</body>

</html>