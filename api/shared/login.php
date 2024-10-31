<?php
class Login
{
  private $conn;

  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  private function setSession($role, $id)
  {
    $_SESSION["role"] = $role;
    $_SESSION["id"] = $id;
  }

  private function sendResponse($code, $message, $success = false)
  {
    http_response_code($code);
    echo json_encode(["message" => $message, "success" => $success]);
    exit;
  }

  public function handleEmailSubmission($role, $email)
  {

    $query = "SELECT `id` FROM `$role` WHERE email = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
      $user = $result->fetch_assoc();
      $response = ["success" => true, "message" => "email_found", "id" => $user["id"]];
    }

    $stmt->close(); // Close statement *before* echoing

    $this->sendResponse(200, $response, true); // Use sendResponse method
  }

  public function handlePasswordSubmission($role, $user_id, $password)
  {
    $response = ["id" => $user_id, "role" => $role, "password" => $password]; // Error response

    $response = ["error" => "incorrect_password"]; // Default error response
    $query = "SELECT id FROM `$role` WHERE id = ? AND password = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("is", $user_id, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result && $result->num_rows > 0) {
      $user = $result->fetch_assoc();

      $this->setSession($role, $user["id"]);
      $response = ["success" => true, "message" => "password_correct"];
      $this->sendResponse(200, $response, true); // Use sendResponse method

    } else {
      $this->sendResponse(404, $response, false); // Use sendResponse method
    }
  }

  public function handleAddPassword($new_pass)
  {
    $role = $_SESSION["role"];
    $email = $_SESSION["email"];

    $query = "UPDATE $role SET `password` = ? WHERE email = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ss", $new_pass, $email);
    $insert = $stmt->execute();

    if ($insert) {
      $query = "SELECT * FROM $role WHERE email = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $this->setSession($role, $user["id"]);
        $this->sendResponse(200, ["success" => true], true); // Use sendResponse method
      }
    } else {
      $this->sendResponse(500, ["error" => "update_failed"], false); // Use sendResponse method
    }
    $stmt->close();
  }
}
