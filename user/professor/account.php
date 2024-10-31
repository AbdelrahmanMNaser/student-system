<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account</title>
</head>

<body>
  <?php
  define('INCLUDE_PATH', '/../../includes/');
  define('NAV_PATH', '/');

  include(__DIR__ . INCLUDE_PATH . 'identity_nav.php');
  include(__DIR__ . NAV_PATH . 'menu_nav.html');
  ?>

  <?php
  $retrieve = "SELECT 
  professor.*,
  (DATE_FORMAT(FROM_DAYS(DATEDIFF(now(), professor.birth_date)), '%Y')+0) AS age,
  department.name AS dept_name
  
  FROM 
  professor, department 
  WHERE 
      professor.department_id = department.id
  AND professor.id = '$_SESSION[id]'
  ";

  $info = $conn->query($retrieve)->fetch_assoc();
  ?>

  <?php
  $retrieve_phone = "SELECT phone_number FROM professor_phone WHERE professor_id = '$_SESSION[id]'";
  $result_phones = $conn->query($retrieve_phone);
  ?>

  <main class="mx-auto grades min-vh-100 py-5 px-3" id="courses">
    <div class="align-items-center mb-3 justify-content-center">
      <div class="row align-items-stretch ">
        <div class="col-lg-6">
          <div class="card h-100">
            <div class="card-header">
              <h3>Personal Information</h3>
            </div>
            <div class="card-body">
              <p>
                <b>First Name: </b>
                <?php echo $info["first_name"] ?>
              </p>
              <p>
                <b>Last Name: </b>
                <?php echo $info["last_name"] ?>
              </p>
              <p>
                <b>Gender: </b>
                <?php echo $info["gender"] ?>
              </p>
              <p>
                <b>Birth Date: </b>
                <?php echo $info["birth_date"] ?>
              </p>
              <p>
                <b>Age: </b>
                <?php echo $info["age"] ?>
              </p>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card h-100">
            <div class="card-header">
              <h3>Academic Information</h3>
            </div>
            <div class="card-body">
              <p>
                <b>Department Name: </b>
                <?php echo $info["dept_name"] ?>
              </p>
              <p>
                <b>Role: </b>
                Professor
              </p>
            </div>
          </div>
        </div>

      </div>
      <div class="row mt-4">
        <div class="col-lg-6">
          <div class="card h-100">
            <div class="card-header">
              <h3>Address</h3>
            </div>
            <div class="card-body">
              <p>
                <b>City: </b>
                <?php echo $info["city"] ?>
              </p>
              <p>
                <b>Street: </b>
                <?php echo $info["street"] ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card h-100">
            <div class="card-header">
              <h3>Contact Information</h3>
            </div>
            <div class="card-body">
              <p>
                <b>E-mail: </b>
                <?php echo $info["email"] ?>
              </p>
              <p>
                <b>Phone Number(s): </b>
              </p>
              <ul>
                <?php


                while ($phoneNumber = $result_phones->fetch_assoc()["phone_number"]) :
                ?>
                  <li><?php echo $phoneNumber ?></li>
                <?php endwhile ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

</body>

</html>