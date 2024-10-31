<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>

</head>
</head>

<body>

  <?php
  define('INCLUDE_PATH', '/../../includes/');
  define('NAV_PATH', '/');

  include(__DIR__ . INCLUDE_PATH . 'identity_nav.php');
  include(__DIR__ . NAV_PATH . 'menu_nav.html');
  include(__DIR__ . INCLUDE_PATH . "current_semester.php");

  get_current_semester();
  ?>


  <main class=" min-vh-100 home-student">
    <div class="container">
      <div class=" row align-items-center justify-content-center">
        <div class="col-md-12 text-center ftco-animate px-5">
          <h1 class=" mb-4 text-white">Welcome, <?php echo " " . $_SESSION['fname']; ?> </h1>

          <?php
          $user_id = $_SESSION['id'];
          $retrieve = "SELECT department.name as dept_name FROM professor, department WHERE department.id = professor.department_id AND professor.id =  $user_id";
          $result = $conn->query($retrieve);
          if ($result->num_rows > 0) {
            $department_name = $result->fetch_assoc()["dept_name"];
          }
          ?>

          <p class="text-white">Alexandria University, Department of
            <span class=" fw-bold"><?php echo $department_name; ?></span>
          </p>

          <? var_dump($_SESSION) ?>

        </div>
      </div>
    </div>
    </div>

  </main>

  <footer>
    <div class=" w-100 py-3 text-center bg-primary">
      <button class=" btn rounded-pill btn-contact">Contact Us</button>
    </div>
  </footer>


</body>

</html>