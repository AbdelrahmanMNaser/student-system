<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
      <h2 class=" f-header fs-1 fw-bold text-white"><?php echo isset($_POST['edit_id']) ? 'Edit Building' : 'Add Building'; ?></h2>
    </header>
    <div class="container">
      <div class="row justify-content-center">
        <form action="" method="post" class="bg-dark col-md-6 text-white p-4 rounded">
          <div class="row mb-3">
            <?php
            $locations = [
              "Moharram Bek" => "Moharram Bek",
              "Shatby" => "Shatby",
              "Abu Qir" => "Abu Qir"
            ];

            // Get the selected location from the POST data (if any)
            $selectedLocation = isset($_POST['edit_id']) ? $_POST['edit_location'] : '';
            ?>

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

          <div class="row mb-3">
            <div class="col">
              <label for="building" class="form-label">Identifier:</label>
              <input type="text" class="form-control text-center" name="name" id="building" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_name'] : ' ' ?>">
            </div>
            <div class="col">
              <label for="floor" class="form-label">Number of Levels:</label>
              <input type="number" class="form-control text-center" name="levels_count" id="floor" min="0" max="6" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_floorcount'] : ' ' ?>">
            </div>
          </div>

          <!-- Submit Button -->
          <div class="text-center">
            <input type="submit" class="btn btn-primary" value="<?php echo isset($_POST['edit_id']) ? 'Edit Building' : 'Add Building'; ?>" name="new_building">
          </div>
        </form>
      </div>
    </div>
    </form>
  </main>

</body>

</html>

<?php
if (isset($_POST["edit_id"])) {
  $_SESSION["building_id_edit"] = $_POST["edit_id"];
}

if (isset($_POST["new_building"])) {
  $name = $_POST["name"];
  $location = $_POST["location"];
  $levels = $_POST["levels_count"];

  if (isset($_SESSION["building_id_edit"])) {
    $update_query = "UPDATE building
    SET
      name = '$name',
      location = '$location',
      number_of_levels = '$levels',

    WHERE id = '$building_num'
    ";
    $update = $conn->query($update_query);

    unset($_SESSION["building_id_edit"]);

    header("location: building_view.php?edit=true");
  } else {
    $insert_query = "INSERT INTO
    building (
      name,
      location,
      number_of_levels
    )
    VALUES (
      '$name',
      '$location',
      $levels
    )
    ";

    $insert = $conn->query($insert_query);

    if ($insert) {
      displayAlert("building", "Added", "success", "Successful!", "Successfully.\nDatabase Insertion Done!", "OK");
    } else {
      displayAlert("building", "Added", "error", "Failed!", "\nPlease Try Again", "Try Again");
    }
  }
}
?>