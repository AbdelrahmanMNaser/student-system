<?php

class CourseController
{
  private $conn;

  public function __construct($db)
  {
    $this->conn = $db->getConnection();
  }

  private function executeQuery($query, $params, $types)
  {
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt;
  }

  private function handleException($e, $message)
  {
    error_log($message . ": " . $e->getMessage());
    $this->sendResponse(500, ["error" => "An error occurred while processing your request."]);
  }

  private function sanitizeInput($data)
  {
    foreach ($data as $key => $value) {
      $data->$key = mysqli_real_escape_string($this->conn, $value);
    }
    return $data;
  }

  private function sendResponse($statusCode, $data)
  {
    http_response_code($statusCode);
    echo json_encode($data);
  }

  public function fetchById($id)
  {
    try {
      $id = mysqli_real_escape_string($this->conn, $id);
      $query = 
          "SELECT 
            c.name AS course_name, 
            c.id AS course_id, 
            c.credit AS course_credits, 
            c.description AS course_description,
            GROUP_CONCAT(c2.name SEPARATOR ', ') AS pre_requisite_names
        FROM 
            course c
        LEFT JOIN 
            course_pre_requisit cp ON c.id = cp.course_id
        LEFT JOIN 
            course c2 ON cp.pre_requisit_id = c2.id
        WHERE 
            c.id = ?
        GROUP BY
            c.id, c.name, c.credit, c.description";
      $stmt = $this->executeQuery($query, [$id], "i");
      $result = $stmt->get_result();
      $record = $result->fetch_assoc();
      if ($record) {
        $response = [
          "id" => htmlspecialchars($record["course_id"]),
          "name" => htmlspecialchars($record["course_name"]),
          "description" => htmlspecialchars($record["course_description"]),
          "credit" => htmlspecialchars($record["course_credits"]),
          "pre_requisites" => htmlspecialchars($record["pre_requisite_names"])
        ];
        $this->sendResponse(200, $response);
      } else {
        $this->sendResponse(404, ["message" => "Course not found"]);
      }
    } catch (Exception $e) {
      $this->handleException($e, "fetchById method");
    }
  }

  public function fetchAll()
  {
    try {
      $query = "SELECT 
                        c.name AS course_name, 
                        c.id AS course_id, 
                        c.credit AS course_credits, 
                        c.description AS course_description,
                        GROUP_CONCAT(c2.name SEPARATOR ', ') AS pre_requisite_names
                    FROM 
                        course c
                    LEFT JOIN 
                        course_pre_requisit cp ON c.id = cp.course_id
                    LEFT JOIN 
                        course c2 ON cp.pre_requisit_id = c2.id
                    GROUP BY
                        c.id, c.name, c.credit, c.description;";
      $stmt = $this->executeQuery($query, [], "");
      $result = $stmt->get_result();
      $courses = [];
      while ($row = $result->fetch_assoc()) {
        $courses[] = [
          "id" => htmlspecialchars($row["course_id"]),
          "name" => htmlspecialchars($row["course_name"]),
          "description" => htmlspecialchars($row["course_description"]),
          "credit" => htmlspecialchars($row["course_credits"]),
          "pre_requisites" => htmlspecialchars($row["pre_requisite_names"])
        ];
      }
      $this->sendResponse(200, $courses);
    } catch (Exception $e) {
      $this->handleException($e, "fetchAll method");
    }
  }

  public function insert()
  {
    $data = json_decode(file_get_contents("php://input"));
    if ($data) {
      $data = $this->sanitizeInput($data);
      $id = $data->id;
      $name = $data->name;
      $credits = $data->credit;
      $description = $data->description;
      $pre_requisites = $data->pre_requisites;

      if (empty($id) || empty($name)) {
        $this->sendResponse(400, ["message" => "Missing required fields", "success" => false]);
        return;
      }

      try {
        $query = "INSERT INTO course (id, name, credit, description) VALUES (?, ?, ?, ?)";
        $this->executeQuery($query, [$id, $name, $credits, $description], "isis");

        if (!empty($pre_requisites)) {
          foreach ($pre_requisites as $pre_req_ID) {
            $query = "INSERT INTO course_pre_requisit (course_id, pre_requisit_id) VALUES (?, ?)";
            $this->executeQuery($query, [$id, $pre_req_ID], "ii");
          }
        }

        $this->sendResponse(201, ["message" => "Course Added Successfully", "success" => true]);
      } catch (Exception $e) {
        $this->handleException($e, "insert method");
      }
    } else {
      $this->sendResponse(400, ["message" => "Invalid input", "success" => false]);
    }
  }

  public function update($id)
  {
    $data = json_decode(file_get_contents("php://input"));
    if ($data) {
      $data = $this->sanitizeInput($data);
      $name = $data->name;
      $credits = $data->credit;
      $description = $data->description;
      $pre_requisites = $data->pre_requisites;

      if (empty($name) || empty($id)) {
        $this->sendResponse(400, ["message" => "Missing required fields", "success" => false]);
        return;
      }

      try {
        $query = "UPDATE course SET name = ?, credit = ?, description = ? WHERE id = ?";
        $this->executeQuery($query, [$name, $credits, $description, $id], "sisi");

        if (!empty($pre_requisites)) {
          foreach ($pre_requisites as $pre_req_ID) {
            $query = "INSERT INTO course_pre_requisit (course_id, pre_requisit_id) VALUES (?, ?)";
            $this->executeQuery($query, [$id, $pre_req_ID], "ii");
          }
        }

        $this->sendResponse(200, ["message" => "Course Updated Successfully", "success" => true]);
      } catch (Exception $e) {
        $this->handleException($e, "update method");
      }
    } else {
      $this->sendResponse(400, ["message" => "Invalid input", "success" => false]);
    }
  }

  public function delete($id)
  {
    if ($id) {
      $id = mysqli_real_escape_string($this->conn, $id);
      try {
        $query = "DELETE FROM course WHERE id = ?";
        $this->executeQuery($query, [$id], "i");

        $this->sendResponse(200, ['success' => true, 'message' => 'Course deleted successfully']);
      } catch (Exception $e) {
        $this->handleException($e, "delete method");
      }
    } else {
      $this->sendResponse(400, ['status' => 'error', 'message' => 'Invalid input']);
    }
  }
}
