<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halls - Add</title>
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
      <h2 class=" f-header fs-1 fw-bold text-white"><?php echo isset($_POST['edit_id']) ? 'Edit Hall' : 'Add Hall'; ?></h2>
    </header>
    <div class="container">
      <div class="row justify-content-center">
        <form action="" method="post" class="bg-dark col-md-6 text-white p-4 rounded">
          <!-- Hall Number -->
          <div class="row mb-3">
            <center>
              <div class="col-md-5">
                <label for="hall_num" class="form-label">Hall Number:</label>
                <input type="number" class="form-control text-center" name="hall_num" id="hall_num" min="1" max="100" step="1" <?php echo isset($_POST['edit_id']) ? 'readonly' : '' ?> value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_id'] : '' ?>">
              </div>
            </center>
          </div>

          <!-- Building and Location -->
          <div class="row mb-3">

            <div class="col-md-6">
              <label for="building" class="form-label">Building:</label>
              <input type="text" class="form-control text-center" name="building" id="building" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_building'] : ' ' ?>">
            </div>

            <?php
            // Define your locations in an array (you might fetch this from a database)
            $locations = [
              "Moharram Bek" => "Moharram Bek",
              "Shatby" => "Shatby",
              "Abu Qir" => "Abu Qir"
            ];

            // Get the selected location from the POST data (if any)
            $selectedLocation = isset($_POST['edit_location']) ? $_POST['edit_location'] : '';
            ?>

            <div class="col-md-6">
              <label for="location" class="form-label">Location:</label>
              <select name="location" id="location" class="form-select text-center">
                <option value="" disabled selected>Select location</option>
                <?php
                foreach ($locations as $value => $text) :
                  $selected = ($value == $selectedLocation) ? 'selected' : '';

                ?>
                  <option value="<?php echo $value ?>" <?php echo $selected ?>> <?php echo $text ?></option>
                <?php endforeach ?>
              </select>
            </div>

          </div>

          <!-- Level and Capacity -->
          <div class="row mb-3">

            <div class="col-md-6">
              <label for="floor" class="form-label">Level:</label>
              <input type="number" class="form-control text-center" name="floor" id="floor" min="0" max="6" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_floor'] : ' ' ?>">
            </div>
            <div class="col-md-6">
              <label for="capacity" class="form-label">Capacity:</label>
              <input type="number" class="form-control text-center" name="capacity" id="capacity" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_capacity'] : ' ' ?>">
            </div>

          </div>

          <!-- Submit Button -->
          <div class="text-center">
            <input type="submit" class="btn btn-primary" value="<?php echo isset($_POST['edit_id']) ? 'Edit Hall' : 'Add Hall'; ?>" name="new_hall">
          </div>
        </form>
      </div>
    </div>
  </main>

  </form>
</body>

</html>
<?php

if (isset($_POST["edit"])) {
  $_SESSION["hall_id_edit"] = $_POST["edit"];
}

if (isset($_POST["new_hall"])) {
  $hall_num = $_POST["hall_num"];
  $location = $_POST["location"];
  $building = $_POST["building"];
  $floor = $_POST["floor"];
  $capacity = $_POST["capacity"];

  if (isset($_SESSION["hall_id_edit"])) {
    $update_query = "UPDATE hall
    SET
      id = '$hall_num',
      location = '$location',
      building = '$building',
      floor = '$floor',
      capacity = '$capacity'

    WHERE id = '$hall_num'
    ";
    $update = $conn->query($update_query);

    unset($_SESSION["hall_id_edit"]);

    header("location: hall_view.php?edit=true");
  } else {
    $insert_query = "INSERT INTO
    hall (
      id,
      location,
      building,
      floor,
      capacity
    )
    VALUES (
      '$hall_num',
      '$location',
      '$building',
      $floor,
      $capacity
    )
    ";

    $insert = $conn->query($insert_query);

    if ($insert) {
      displayAlert("Hall", "Added", "success", "Successful!", "Successfully.\nDatabase Insertion Done!", "OK");
    } else {
      displayAlert("Hall", "Added", "error", "Failed!", "\nPlease Try Again", "Try Again");
    }
  }
}
?>