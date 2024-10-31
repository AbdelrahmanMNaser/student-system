<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student - Add</title>

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
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white"><?php echo isset($_POST['edit_id']) ? 'Edit Student' : 'Add Student'; ?></h2>
    </header>
    <div class="container">
      <div class="row justify-content-center">
        <?
        ?>
        <form action="" method="post" class="bg-dark text-white col-md-6 p-4 rounded">

          <?php
          // Get the selected department from the POST data (if any)
          $selectedDepartment = isset($_POST['edit_dept_name']) ? $_POST['edit_dept_name'] : '';

          // Fetch departments from the database
          $retrieve_query = "SELECT name FROM department";
          $result = $conn->query($retrieve_query);
          ?>

          <div class="mb-3">
            <label for="dept" class="form-label">Department Name</label>
            <select name="dept" id="dept" class="form-select text-center">
              <option value="" disabled <?php echo ($selectedDepartment == '') ? 'selected' : ''; ?>>Select department</option>
              <?php
              while ($row = $result->fetch_assoc()) :
                $selected = ($row['name'] == $selectedDepartment) ? 'selected' : '';
              ?>
                <option value="<?php echo $row['name'] ?>" <?php echo $selected ?>><?php echo $row["name"] ?></option>
              <?php endwhile ?>
            </select>
          </div>

          <!-- First Name and Last Name -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="fname" class="form-label">First Name:</label>
              <input type="text" class="form-control text-center" name="fname" id="fname" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_fname'] : '' ?>" required>
            </div>
            <div class="col-md-6">
              <label for="lname" class="form-label">Last Name:</label>
              <input type="text" class="form-control text-center" name="lname" id="lname" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_lname'] : '' ?>" required>
            </div>
          </div>

          <?php
          $genders = [
            "Male" => "Male",
            "Female" => "Female"
          ];

          // Get the selected gender from the POST data (if any)
          $selectedGender = isset($_POST['edit_gender']) ? $_POST['edit_gender'] : '';
          ?>

          <!-- Gender -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="gender" class="form-label">Gender:</label>
              <select name="gender" id="gender" class="form-select text-center" required>
                <option value="" disabled selected>Select Gender</option>
                <?php
                foreach ($genders as $value => $text) :
                  $selected = ($value == $selectedGender) ? 'selected' : '';
                ?>
                  <option value="<?php echo $value ?>" <?php echo $selected ?>> <?php echo $text ?></option>

                <?php endforeach ?>
              </select>
            </div>

            <!-- Birth Date -->
            <div class="col-md-6">
              <label for="birth" class="form-label">Birth Date:</label>
              <input type="date" class="form-control text-center" name="birth" id="birth" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_bdate'] : '' ?>" required>
            </div>

          </div>

          <!-- City and Street -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="city" class="form-label">City:</label>
              <input type="text" class="form-control text-center" name="city" id="city" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_city'] : '' ?>">
            </div>
            <div class="col-md-6">
              <label for="street" class="form-label">Street:</label>
              <input type="text" class="form-control text-center" name="street" id="street" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_street'] : '' ?>">
            </div>
          </div>

          <script src="/assets/js/phone_input.js"></script>

          <!-- Phone Numbers -->
          <div id="inputArea" class="row g-2 mb-3">
            <!-- Phone number inputs will be added here -->
          </div>
          <p style="color: blue; cursor: pointer;" onclick="addPhoneNumberInput()">Add Phone Numbers</p>

          <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" id="email" class="form-control text-center" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_email'] : '' ?>" required>
          </div>


          <!-- Submit Button -->
          <div class="text-center">
            <input type="submit" class="btn btn-primary" name="new_student" value="<?php echo isset($_POST['edit_id']) ? 'Edit Student' : 'Add Student'; ?>">
          </div>
        </form>
      </div>
    </div>
  </main>


</body>

</html>


<?php

if (isset($_POST["edit_id"])) {
  $_SESSION["student_edit_id"] = $_POST["edit_id"];
}

if (isset($_POST["new_student"])) {
  $id = $_POST["id"];
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $email = $_POST["email"];
  $gender = $_POST["gender"];
  $city = $_POST["city"];
  $street = $_POST["street"];
  $birth = $_POST["birth"];
  $dept_name = $_POST["dept"];
  $registration_date = date("y-m-d");

  $retrieve = "SELECT id FROM department WHERE name = '$dept_name'";

  $result = $conn->query($retrieve);

  if ($result && $result->num_rows > 0) {
    $dept_id = $result->fetch_assoc()['id'];
  }

  if (isset($_SESSION["student_edit_id"])) {
    $update_query = "UPDATE student
    SET
      id = '$id',
      first_name = '$fname',
      last_name = '$lname',
      department_id = '$dept_id',
      gender = '$gender',
      birth_date = '$birth',
      city = '$city',
      street = '$street',
      email = '$email'
    
    WHERE id = '$id'
    ";
    $update = $conn->query($update_query);

    if ($update) {
      header("location: view.php?edit=true");
      unset($_SESSION["student_edit_id"]);
    } else {
      var_dump($update_query);
    }
  } else {
    $insert_query = "INSERT INTO 
    student (
      id, 
      first_name, 
      last_name, 
      department_id, 
      registration_date,
      gender, 
      birth_date, 
      city, 
      street, 
      email
    ) 
    VALUES (
      '$id', 
      '$fname',  
      '$lname',  
      '$dept_id',
      '$registration_date',  
      '$gender', 
      '$birth', 
      '$city' , 
      '$street',  
      '$email'
        )
    ";

    $insert = $conn->query($insert_query);

    if ($insert) {
      displayAlert("Student", "Added", "success", "Successful!", "Successfully.\nDatabase Insertion Done!", "OK");
    } else {
      displayAlert("Student", "Added", "error", "Failed!", "\nPlease Try Again", "Try Again");
    }
  }

  for ($i = 0; isset($_POST["phone" . $i]); $i++) {
    $phoneNumber = $_POST["phone" . $i];

    $insert_query = "INSERT INTO 
        student_phone (
            student_id,
            phone_number
        )
        vALUES (
            '$id',
            '$phoneNumber'
        )
        ";

    $insert = $conn->query($insert_query);
  }
}


?>