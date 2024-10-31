<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Semester - View</title>
</head>

<body>
  <?php
  include("../../includes/identity_nav.php");
  include("menu_nav.html");
  ?>

  <main class="mx-auto admin text-center min-vh-100 py-5 px-3">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">View Semester</h2>
    </header>

    <table class="table table-bordered text-center">
      <thead>
        <th>Year</th>
        <th>Semester</th>
        <th>Number of Courses</th>
        <th>Number of Professors</th>
        <th>Number of Students</th>

      </thead>
      <tbody>

        <?php
        $retrieve = "SELECT 
            semester.*,
            COUNT(DISTINCT enrollment.course_id) AS num_courses,
            COUNT(DISTINCT enrollment.student_id) AS num_students,
            COUNT(DISTINCT teaching.professor_id) AS num_profs

            FROM 
                semester, enrollment, teaching

            WHERE
                semester.id = enrollment.semester_id
                AND semester.id = teaching.semester_id

            GROUP BY
                semester.id
        
            ";

        $result = $conn->query($retrieve);
        while ($row = $result->fetch_assoc()) :
          $semester_name = $row["semester"];
          $semester_year = $row["year"];
          $num_courses = $row["num_courses"];
          $num_profs = $row["num_profs"];
          $num_students = $row["num_students"];
        ?>
          <tr>
            <td> <?php echo $semester_year ?> </td>
            <td> <?php echo $semester_name ?> </td>
            <td> <?php echo $num_courses ?> </td>
            <td> <?php echo $num_profs ?> </td>
            <td> <?php echo $num_students ?> </td>

          </tr>
        <?php endwhile ?>
      </tbody>
    </table>
  </main>
</body>

</html>