<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Semester - Add</title>
</head>

<body>
  <?php
  define('INCLUDE_PATH', '/../../../includes/');
  define('NAV_PATH', '/../');

  include(__DIR__ . INCLUDE_PATH . 'identity_nav.php');
  include(__DIR__ . NAV_PATH . 'menu_nav.html');
  include(__DIR__ . INCLUDE_PATH . 'alerts.php');
  ?>


  <main class="mx-auto grades text-center min-vh-100 py-5 px-3">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form action="" method="post" class="bg-dark text-white p-4 rounded">

            <div class="row g-2 mb-3">

              <div class="col-md-6">
                <label for="name" class="form-label">Semester Name:</label>
                <select name="name" id="name" class="form-select text-center">
                  <option value="" disabled selected>select semester</option>
                  <option value="Fall">Fall</option>
                  <option value="Spring">Spring</option>
                  <option value="Summer">Summer</option>
                </select>
              </div>

              <div class="col-md-6">
                <label for="year" class="form-label">Year:</label>
                <input type="number" class="form-control text-center" name="year" id="year" min="2024" step="1">
              </div>

            </div>

            <div class="row g-2 mb-3">

              <div class="col-md-6">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" class="form-control text-center" name="start_date" id="start_date">
              </div>

              <div class="col-md-6">
                <label for="end_date" class="form-label">Maximum End Date:</label>
                <input type="date" class="form-control text-center" name="end_date" id="end_date">
              </div>

            </div>

            <div class="text-center">
              <input type="submit" class="btn btn-primary" value="Add Semester" name="new_semester">
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>

</body>

</html>

<?php
if (isset($_POST["new_semester"])) {
  $semester = $_POST["name"];
  $year = $_POST["year"];
  $start_date = $_POST["start_date"];
  $end_date = $_POST["end_date"];

  $insert_query = "INSERT into
    semester (
        semester,
        year,
        start_date,
        end_date
    )
    VALUES (
        '$semester',
        '$year',
        '$start_date',
        '$end_date'
    )
    ";

  $insert = $conn->query($insert_query);

  if ($insert) {
    displayAlert("Semester", "Added", "success", "Successful!", "Successfully.\nDatabase Insertion Done!", "OK");
  } else {
    displayAlert("Semester", "Added", "error", "Failed!", "\nPlease Try Again", "Try Again");
  }
}

?>