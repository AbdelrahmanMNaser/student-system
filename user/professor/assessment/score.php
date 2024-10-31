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
    <?php
    print_header_choosenCourseSemester("white");
    ?>
    <a href="score-submit.php" class="btn btn-primary btn-lg me-5">Submit</a>
    <a href="score-view.php" class="btn btn-primary btn-lg">View</a>
  </main>

</body>

</html>