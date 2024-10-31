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
  include(__DIR__ . INCLUDE_PATH . 'number_formatting.php');
  ?>

  <main class="mx-auto grades text-center min-vh-100 py-5 px-3">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white"><?php echo isset($_POST['edit_id']) ? 'Edit Room' : 'Add Room'; ?></h2>
    </header>
    <div class="container">
      <div class="row justify-content-center">
        <form action="" method="post" class="bg-dark col-md-6 text-white p-4 rounded">
          <div class="row mb-3">
            <label for="building" class="form-label">Building:</label>
            <select name="building_id" id="building" class="form-select text-center" onchange="this.form.submit()">
              <option value="" disabled selected>Select building</option>
              <?php
              $retrieve = "SELECT * FROM building";
              $result = $conn->query($retrieve);

              $lastLoc = null;
              while ($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $name = $row["name"];
                $location = $row["location"];


                if ($lastLoc != $location) {
                  if ($lastLoc != null) {
                    echo "</optgroup>";
                  }

                  echo "<optgroup label='$location'>";
                  $lastLoc = $location;
                }

                echo "<option value='$id'>Building '$name'</option>";
              }
              if ($lastLoc != null) {
                echo "</optgroup>";
              }
              ?>
            </select>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label for="room" class="form-label">Room Type:</label>
              <select name="room_type" id="room" class="form-select text-center">
                <option value="" disabled selected>Select Type</option>
                <option value="Hall">Hall</option>
                <option value="Lab">Lab</option>
                <option value="Office">Office</option>
              </select>
            </div>
            <div class="col">
              <label for="building" class="form-label">Identifier:</label>
              <input type="text" class="form-control text-center" name="name" id="building" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_name'] : ' ' ?>">
            </div>
          </div>

          <!-- Level and Capacity -->

          <div class="row mb-3">

            <div class="col">
              <?php
              $retrieve = "SELECT number_of_levels FROM building WHERE id = '$_SESSION[building]'";
              $result = $conn->query($retrieve);
              $max_level = $result->fetch_assoc()["number_of_levels"];;
              ?>
              <label for="level" class="form-label">Level:</label>
              <select name="level" id="level" class="form-select text-center">
                <option value="" disabled selected>Select level</option>
                <option value="Ground">Ground</option>
                <?php
                for ($i = 1; $i <= $max_level; $i++) :
                ?>
                  <option value="<?php echo toOrdinary($i) ?>"><?php echo toOrdinary($i) ?></option>
                <?php endfor ?>
              </select>
            </div>

            <div class="col">
              <label for="capacity" class="form-label">Number of Seats:</label>
              <input type="number" class="form-control text-center" name="capacity" id="capacity" min="0" max="1000" value="<?php echo isset($_POST['edit_id']) ? $_POST['edit_capacity'] : ' ' ?>">
            </div>

          </div>

          <!-- Submit Button -->
          <div class="text-center">
            <input type="submit" class="btn btn-primary" value="<?php echo isset($_POST['edit_id']) ? 'Edit Room' : 'Add Room'; ?>" name="new_room">
          </div>
        </form>
      </div>
    </div>
    </form>
  </main>
  <script src="/assets/js/save_select.js"></script>
  <script>
    handleDataUpdate('building');
  </script>
</body>

</html>
<?php
if (isset($_POST["edit_id"])) {
  $_SESSION["room_id_edit"] = $_POST["edit_id"];
}

if (isset($_POST["new_room"])) {
  $name = $_POST["name"];
  $building_id = $_POST["building_id"];
  $room_type = $_POST["room_type"];
  $level = $_POST["level"];
  $capacity = $_POST["capacity"];

  if (isset($_POST["edit_id"])) {
    $update_query = "UPDATE room
    SET
      building_id = '$building_id',
      name = '$name',
      type = '$room_type',
      level = '$level',
      capacity = '$capacity'
    WHERE id = '$_SESSION[room_id_edit]'
    ";

    $update = $conn->query($update_query);

    unset($_SESSION["room_id_edit"]);
    header("location: view.php?edit=true");
  } else {
    $insert_query = "INSERT INTO 
    room (      
      building_id, 
      name, 
      type, 
      level, 
      capacity
    )     
    VALUES ( 
      '$building_id',
      '$name', 
      '$room_type', 
      '$level', 
      '$capacity'
    )
    ";

    $insert = $conn->query($insert_query);
  }

  if ($insert) {
    header("location: view.php?add=true");
  }
}

?>