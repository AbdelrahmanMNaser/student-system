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
      <h2 class=" f-header fs-1 fw-bold text-white">View Buildings</h2>
    </header>
    <table class="table table-bordered">
      <thead>
        <th>Location</th>
        <th>Identifier</th>
        <th>Number Of Levels</th>

        <th colspan="2">Actions</th>
      </thead>
      <tbody>

        <?php
        $retrieve = "SELECT * from building";

        $result = $conn->query($retrieve);
        while ($row = $result->fetch_assoc()) :
          $num = $row["id"];
          $location = $row["location"];
          $building = $row["name"];
          $levels_count = $row["number_of_levels"];
        ?>

          <tr>
            <td> <?php echo $location ?> </td>
            <td> <?php echo $building ?> </td>
            <td> <?php echo $levels_count ?> </td>

            <td>
              <form action="add.php" method="post" onsubmit="confirmEdit(event, 'Building <?php echo $building ?>');">
                <input type="hidden" name="edit_id" value="<?php echo $num ?>">
                <input type="hidden" name="edit_location" value="<?php echo $location ?>">
                <input type="hidden" name="edit_name" value="<?php echo $building ?>">
                <input type="hidden" name="edit_levelcount" value="<?php echo $levels_count ?>">
                <button type="submit" class="btn btn-warning">
                  <i class="fas fa-edit"></i>
                </button>
              </form>
            </td>

            <td>
              <form action="" method="post" onsubmit="confirmRemove(event, 'Building <?php echo $building ?>');">
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
      showAlert("Edit Successful", "Building data is editted Successfully", "info", "OK");
    }

    if (new URLSearchParams(window.location.search).has("delete")) {
      showAlert("delete Successful", "Building data is deleted Successfully", "info", "OK");
    }
  </script>
</body>

</html>

<?php
if (isset($_POST["delete_id"])) {
  $pk_value = $_POST["delete_id"];
  delete_Row("building", "id", $pk_value);

  header("location: view.php?delete=true");
}
?>