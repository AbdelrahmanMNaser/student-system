<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?php echo $_SESSION["choosen_course"] ?></title>


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

    <a href="view-task.php">
      <button class="btn btn-primary btn-lg me-5">Tasks</button>
    </a>

    <a href="view-score.php">
      <button class="btn btn-primary btn-lg me-5">Scores</button>
    </a>

  </main>


</body>

</html>