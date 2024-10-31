<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hall - View</title>
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
      <h2 class=" f-header fs-1 fw-bold text-white">View Hall</h2>
    </header>
    <table class="table table-bordered">
      <thead>
        <th>Hall no.</th>
        <th>Location</th>
        <th>Building</th>
        <th>Floor</th>
        <th>Capacity</th>
        <th colspan="2">Actions</th>
      </thead>
      <tbody>

        <?php
        $retrieve = "SELECT * from Hall";

        $result = $conn->query($retrieve);
        while ($row = $result->fetch_assoc()) :
          $num = $row["id"];
          $location = $row["location"];
          $building = $row["building"];
          $floor = $row["floor"];
          $capacity = $row["capacity"];
        ?>

          <tr>
            <td> <?php echo $num ?> </td>
            <td> <?php echo $location ?> </td>
            <td> <?php echo $building ?> </td>
            <td> <?php echo $floor ?> </td>
            <td> <?php echo $capacity ?> </td>

            <td>
              <form action="add.php" method="post" onsubmit="confirmEdit(event, 'Hall <?php echo $num ?> - Building <?php echo $building ?>');">
                <input type="hidden" name="edit_id" value="<?php echo $num ?>">
                <input type="hidden" name="edit_capacity" value="<?php echo $capacity ?>">
                <input type="hidden" name="edit_location" value="<?php echo $location ?>">
                <input type="hidden" name="edit_building" value="<?php echo $building ?>">
                <input type="hidden" name="edit_floor" value="<?php echo $floor ?>">
                <button type="submit" class="btn btn-warning">
                  <i class="fas fa-edit"></i>
                </button>
              </form>
            </td>

            <td>
              <form action="" method="post" onsubmit="confirmRemove(event, 'Hall <?php echo $num ?> - Building <?php echo $building ?>');">
                <input type="hidden" name="delete" value="<?php echo $num ?>">
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
      showAlert("Edit Successful", "Hall data is editted Successfully", "info", "OK");
    }
  </script>
</body>

</html>