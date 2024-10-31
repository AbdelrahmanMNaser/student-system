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
  include(__DIR__ . INCLUDE_PATH . "delete_item.php");
  ?>

  <main class="mx-auto admin text-center min-vh-100 py-5 px-3">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">View Rooms</h2>
    </header>
    <table class="table table-light table-bordered">
      <thead>
        <th>Location</th>
        <th>Building Identifier</th>
        <th>Room</th>
        <th>Level</th>
        <th>Capacity</th>
        <th colspan="2">Actions</th>
      </thead>
      <tbody>

        <?php
        $retrieve = "SELECT 
                      room.*, 
                      building.location, 
                      building.name AS building_identifier 
                    FROM 
                      room, building
                    WHERE 
                      building.id = room.building_id
                    ORDER BY 
                      building.location ASC, 
                      building.name ASC
        ";

        $result = $conn->query($retrieve);
        while ($row = $result->fetch_assoc()) :
          $id = $row["room_id"];
          $location = $row["location"];
          $building_id = $row["building_id"];
          $building_name = $row["building_identifier"];
          $type = $row["type"];
          $room = $row["name"];
          $level = $row["level"];
          $capacity = $row["capacity"];
        ?>

          <tr>
            <td><?php echo $location ?></td>
            <td><?php echo $building_name ?></td>
            <td><?php echo $type ?> <?php echo $room ?></td>
            <td><?php echo $level ?></td>
            <td><?php echo $capacity ?></td>

            <td>
              <form action="add.php" method="post" onsubmit="confirmEdit(event, '<?php echo $type . ' ' . $room ?> - Building <?php echo $building ?>');">
                <input type="hidden" name="edit_id" value="<?php echo $id ?>">
                <input type="hidden" name="edit_location" value="<?php echo $location ?>">
                <input type="hidden" name="edit_building_name" value="<?php echo $building ?>">
                <input type="hidden" name="edit_type" value="<?php echo $type ?>">
                <input type="hidden" name="edit_name" value="<?php echo $room ?>">
                <input type="hidden" name="edit_level" value="<?php echo $level ?>">
                <input type="hidden" name="edit_capacity" value="<?php echo $capacity ?>">
                <button type="submit" class="btn btn-warning">
                  <i class="fas fa-edit"></i>
                </button>
              </form>
            </td>

            <td>
              <form action="" method="post" onsubmit="confirmRemove(event, '<?php echo $type . ' ' . $room ?> - Building <?php echo $building ?>');">
                <input type="hidden" name="delete_id" value="<?php echo $id ?>">
                <button type="submit" class="btn btn-danger">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>

          </tr>
        <?php endwhile ?>
      </tbody>
    </table>
  </main>
  <script>
    if (new URLSearchParams(window.location.search).has("edit")) {
      showAlert("Edit Successful", "Room data is editted Successfully", "info", "OK");
    }

    if (new URLSearchParams(window.location.search).has("delete")) {
      showAlert("delete Successful", "Room data is deleted Successfully", "info", "OK");
    }
  </script>
</body>

</html>

<?php
if (isset($_POST["delete_id"])) {
  $pk_value = $_POST["delete_id"];
  delete_Row("room", "room_id", $pk_value);

  header("location: view.php?delete=true");
}
?>