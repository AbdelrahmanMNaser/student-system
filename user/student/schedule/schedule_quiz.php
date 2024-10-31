<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>University</title>

  <script src="/assets/js/jquery-3.7.1.min.js"></script>

</head>

<body>
  <?php
  include("../../includes/identity_nav.php");
  include("menu_nav.html");
  include("../../includes/print_data_input.php");
  ?>

  <main class="mx-auto quizes min-vh-100 text-center py-5 px-3" id="courses">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold">Quizes</h2>
    </header>

    <form action="" id="course_view" method="post">
      <select class="form-select w-15 mx-auto mb-4" id="semester" name="semester" onchange="this.form.submit()">
        <option value="" disabled selected>Select Semester</option>
        <?php
        print_semesters("enrollment", "student");
        ?>
      </select>
    </form>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Day</th>
          <th>Course</th>
          <th>Credits</th>
          <th>Hall</th>
          <th>Start time</th>
          <th>End Time</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Saturday</td>
          <td>Web programming</td>
          <td>3</td>
          <td>Hall 4</td>
          <td>1:00</td>
          <td>3:00</td>
          <td>21/5/2024</td>
        </tr>
        <tr>
          <td>Sunday</td>
          <td>Database</td>
          <td>3</td>
          <td>Hall 4</td>
          <td>1:00</td>
          <td>3:00</td>
          <td>23/5/2024</td>
        </tr>
      </tbody>
    </table>

  </main>

  <script src="/assets/js/save_select.js"></script>
</body>

</html>