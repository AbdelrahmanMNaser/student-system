<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
    <?php
    $retrieve = "SELECT
          DISTINCT 
            assessment.type,
            assessment.format,
            assessment.max_score,
            assessment.description,
            assessment_onsite_schedule.due_date AS assess_onsite_date,
            assessment_onsite_schedule.start_time AS assess_onsite_start,
            assessment_onsite_schedule.end_time AS assess_onsite_end,
            assessment_online_schedule.due_date AS assess_online_date,
            assessment_online_schedule.start_time AS assess_online_start,
            assessment_online_schedule.end_time AS assess_online_end,
            assessment_link.url
        FROM
            enrollment
        JOIN
            assessment 
            ON assessment.course_id = enrollment.course_id AND assessment.semester_id = enrollment.semester_id
        LEFT JOIN
            assessment_onsite_schedule 
            ON assessment.assess_id  = assessment_onsite_schedule.assessment_id
        LEFT JOIN
            assessment_online_schedule 
            ON assessment.assess_id  = assessment_online_schedule.assessment_id
        LEFT JOIN
            assessment_link
            ON assessment.assess_id  = assessment_link.assessment_id
        WHERE
            enrollment.course_id = '$_SESSION[choosen_course_id]'
            AND enrollment.semester_id = '$_SESSION[semester]'
            AND enrollment.student_id = '$_SESSION[id]'
          ";

    $result = $conn->query($retrieve);
    ?>

    <div class="d-flex align-items-center mb-3 justify-content-center">
      <table class="table table-bordered">
        <thead>
          <th>Task</th>
          <th>Format</th>
          <th>Max Score</th>
          <th>Due Date</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Description</th>
          <th>illustration File</th>
          <th>Submission Link</th>
        </thead>

        <tbody>
          <?php
          while ($row = $result->fetch_assoc()) :
            $task = $row["type"];
            $format = $row["format"];
            $max_score = $row["max_score"];
            $description = $row["description"];
            $url = $row["url"];
            $fileName = $row["file_name"];
            $filePath = $row["file_path"];
            $due_date = $start_time = $end_time = null;

            if ($format == "Onsite") {
              $due_date = $row["assess_onsite_date"];
              $start_time = $row["assess_onsite_start"];
              $end_time = $row["assess_onsite_end"];
            } elseif ($format == "Online") {
              $due_date = $row["assess_online_date"];
              $start_time = $row["assess_online_start"];
              $end_time = $row["assess_online_end"];
            }

            // Convert to 12-hour format with AM/PM
            $start_time = date("g:i A", strtotime($start_time));
            $end_time = date("g:i A", strtotime($end_time));

          ?>
            <tr>
              <td><?php echo $task ?></td>
              <td><?php echo $format ?></td>
              <td><?php echo $max_score ?></td>
              <td><?php echo $due_date ?></td>
              <td><?php echo $start_time ?></td>
              <td><?php echo $end_time ?></td>
              <td><?php echo $description ?></td>
              <td>

              </td>
              <td>
                <?php if ($url) : ?>
                  <a href="<?php echo $url ?>" target="_blank">Link</a>
                <?php endif ?>
              </td>
            </tr>

          <?php endwhile ?>

        </tbody>

      </table>
    </div>
  </main>
</body>

</html>