<?php
class SessionInfoController
{
  private $conn;

  public function __construct($db)
  {
    $this->conn = $db->getConnection();
  }

  public function handleRequest($request)
  {
    switch ($request) {
      case "GET":
        $this->fetchSessionInfo();
        break;
      default:
        $this->sendResponse(400, "Invalid request");
    }
  }

  private function fetchSessionInfo()
  {
    if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
      $this->sendResponse(400, "Session data missing");
      return;
    }

    $role = $_SESSION['role'];
    $id = $_SESSION['id'];

    $retrieve = "SELECT first_name, gender, email FROM `$role` WHERE id = ?";
    $stmt = $this->conn->prepare($retrieve);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $response = array(
        "email" => $row["email"],
        "first_name" => $row["first_name"],
        "title" => $this->getTitle($row["gender"]),
        "role" => $_SESSION["role"]
      );
      $this->sendResponse(200, $response, true);
    } else {
      $this->sendResponse(404, "No data found");
    }
  }

  private function getTitle($gender)
  {
    if ($_SESSION["role"] == "admin") {
      return $gender == "Male" ? "Mr. " : "Mrs. ";
    } elseif ($_SESSION["role"] == "Professor") {
      return "Dr. ";
    }
    return "";
  }

  private function sendResponse($code, $message, $success = false)
  {

    http_response_code($code);
    echo json_encode(["message" => $message, "success" => $success]);
  }
}
