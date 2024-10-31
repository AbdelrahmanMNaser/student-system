<?php

class DepartmentController
{
  private $conn;

  public function __construct($db)
  {
    $this->conn = $db->getConnection();
  }

  public function handleRequest()
  {
    $request = $_SERVER['REQUEST_METHOD'];

    switch ($request) {
      case 'GET':
        $this->fetch();
        break;
      case 'POST':
        $this->insert();
        break;
      case 'PUT':
        $this->update();
        break;
      case 'DELETE':
        $this->delete();
        break;
      default:
        echo json_encode(array("message" => "Invalid request", "success" => false));
        break;
    }
  }

  private function fetch()
  {
    try {
      $retrieve = "SELECT 
                    id, 
                    name,
                    (SELECT COUNT(*) FROM student WHERE student.department_id = department.id) AS num_students,
                    (SELECT COUNT(*) FROM professor WHERE professor.department_id = department.id) AS num_profs
                  FROM 
                    department";

      $stmt = $this->conn->prepare($retrieve);
      $stmt->execute();
      $result = $stmt->get_result();
      $records = [];
      while ($row = $result->fetch_assoc()) {
        $records[] = [
          "id" => htmlspecialchars($row["id"]),
          "name" => htmlspecialchars($row["name"]),
          "num_students" => htmlspecialchars($row["num_students"]),
          "num_profs" => htmlspecialchars($row["num_profs"])
        ];
      }
      echo json_encode($records);
    } catch (Exception $e) {
      // Log the error message
      error_log($e->getMessage());
      // Return a generic error message to the client
      echo json_encode(["error" => "An error occurred while fetching data."]);
    }
  }

  private function insert()
  {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data)) {
      $name = $data->name;
      $insert = "INSERT INTO department (name) VALUES (?)";
      $stmt = $this->conn->prepare($insert);
      $stmt->bind_param("s", $name);
      $stmt->execute();

      echo json_encode(['status' => 'success', 'message' => 'Department added successfully']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Department name not provided']);
    }
  }

  private function update()
  {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data)) {
      $id = $data->id;
      $name = $data->name;

      $update = "UPDATE department SET name = ? WHERE id = ?";
      $stmt = $this->conn->prepare($update);
      $stmt->bind_param("si", $name, $id);
      $stmt->execute();

      echo json_encode(['status' => 'success', 'message' => 'Department updated successfully']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Department name not provided']);
    }
  }

  private function delete()
  {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data)) {
      $id = $data;

      $delete = "DELETE FROM department WHERE id = ?";
      $stmt = $this->conn->prepare($delete);
      $stmt->bind_param("i", $id);
      $stmt->execute();

      echo json_encode(['status' => 'success', 'message' => 'the dept deleted successfully', 'id' => $id]);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Department ID not provided']);
    }
  }
}

// Initialize the database and controller
$db = new Database();
$controller = new DepartmentController($db);
$controller->handleRequest();
