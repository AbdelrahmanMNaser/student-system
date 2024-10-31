<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="/assets/js/jquery-3.7.1.min.js"></script>
  <title><?php echo $_SESSION["choosen_course_name"] ?> Scores</title>

</head>

<body>
  <?php
  define('INCLUDE_PATH', '/../../../includes/');
  define('NAV_PATH', '/../');

  include(__DIR__ . INCLUDE_PATH . 'identity_nav.php');
  include(__DIR__ . NAV_PATH . 'menu_nav.html');
  include(__DIR__ . INCLUDE_PATH . "print_data_input.php");
  ?>
  <main class="mx-auto final min-vh-100 text-center py-5 px-3" id="courses">

    <?php
    print_header_choosenCourseSemester("grey");
    ?>

    <table class="table table-bordered">
      <?php

      $choosen_semester = $_SESSION["semester"];
      $choosen_course = $_SESSION["choosen_course_id"];


      $retrieve = "SELECT 
      Assessment.type, 
      Assessment.max_score,
      Assessment_score.score
    FROM 
      Assessment, Assessment_score
    WHERE
        Assessment.semester_id = '$choosen_semester'
        AND Assessment.course_id = '$choosen_course'
        AND Assessment_score.Assessment_id = Assessment.assess_id
        AND Assessment_score.student_id = '$_SESSION[id]'
    ";
      $result = $conn->query($retrieve);

      $data = [];
      $max_scores = array();
      $max_total = 0;

      while ($row = $result->fetch_assoc()) {
        $data[$row["type"]] = $row["score"];
        $data["Total"] += $row["score"];

        $max_scores[$row["type"]] = $row["max_score"];
        $max_total += $row["max_score"];
      }

      if ($data["Final"]) {
        $final = $data["Final"];
        unset($data["Final"]);
        $data["Final"] = $final;
      }


      if ($data["Total"]) {
        $total_score = $data["Total"];
        unset($data["Total"]);
        $data["Total"] = $total_score;
      }


      echo "<thead>";
      echo "<tr>";
      foreach (array_keys($data) as $type) {
        echo "<th>";
        if ($type == "Total")
          echo $type .  "  (" . $max_total . ")";

        else
          echo $type . " (" . $max_scores[$type] . ")";

        echo "</th>";
      }
      echo "</tr>";
      echo "</thead>";

      echo "<tbody>";
      echo "<tr>";
      foreach ($data as $type => $score) {
        echo "<td>";
        echo $score;

        echo "</td>";
      }
      echo "</tr>";
      echo "</tbody>";
      ?>

    </table>



  </main>
</body>

</html>