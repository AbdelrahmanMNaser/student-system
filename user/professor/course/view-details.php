<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <script src="/assets/js/jquery-3.7.1.min.js"></script>
</head>
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
    <a href="../assessment/main.php" class="btn btn-primary btn-lg">Assessment</a>

  </main>

</body>

</html>