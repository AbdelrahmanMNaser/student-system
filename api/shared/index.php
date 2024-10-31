<?php
session_start();

ini_set('output_buffering', 'Off');



require_once '../config/Database.php';
require_once 'login.php';
require_once 'logout.php';
require_once 'update_session.php';
require_once 'session_info.php';

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Content-Type: application/json");

class APIGateway
{
  private $db;
  private $path;
  private $method;
  private $params;

  public function __construct($db)
  {
    $this->db = $db;
    $this->path = $_SERVER['REQUEST_URI'];
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->params = explode('/', trim($this->path, '/'));
  }

  private function sendResponse($code, $message, $success = false)
  {
    http_response_code($code);
    echo json_encode(["message" => $message, "success" => $success]);
    exit;
  }

  public function handleRequest()
  {
    if (count($this->params) < 2) {
      $this->sendResponse(400, "Bad Request");
      return;
    }

    while (ob_get_level()) {
      ob_end_clean();
    }

    $endpoint = $this->params[2];

    switch ($endpoint) {
      case 'login':
        $this->handleLogin();
        break;
      case 'logout':
        $this->handleLogout();
        break;
      case 'update_session':
        $this->handleUpdateSession();
        break;
      case 'session_info':
        $this->handleSessionInfo();
        break;
      default:
        $this->sendResponse(404, "Not Found");
        break;
    }
  }

  private function handleLogin()
  {
    $controller = new Login($this->db->getConnection());
    $data = json_decode(file_get_contents('php://input'), true);

    switch ($this->method) {
      case 'POST':
        $this->handleLoginPost($controller, $data);
        break;
      case 'PUT':
        $this->handleLoginPut($controller, $data);
        break;
      default:
        $this->sendResponse(405, "Method Not Allowed");
        break;
    }
  }

  private function handleLoginPost($controller, $data)
  {
    if (isset($data['email']) && isset($data['role'])) {
      $controller->handleEmailSubmission($data['role'], $data['email']);
    } elseif (isset($data['password']) &&  isset($data['role'])) {

      $controller->handlePasswordSubmission($data['role'], $data['id'], $data['password']);
    } else {
      echo json_encode(["hey, ur data is: " => $data]); // Default error response
    }
  }

  private function handleLoginPut($controller, $data)
  {
    if (isset($data['new_password'])) {
      $controller->handleAddPassword($data['new_password']);
    } else {
      $this->sendResponse(400, "Bad Request");
    }
  }

  private function handleLogout()
  {
    new Logout();
  }

  private function handleUpdateSession()
  {
    if ($this->method === 'POST') {
      $this->sendResponse(200, "Session updated", true);
    } else {
      $this->sendResponse(405, "Method Not Allowed");
    }
  }

  private function handleSessionInfo()
  {
    $controller = new SessionInfoController($this->db);
    $controller->handleRequest($this->method);
  }
}

$db = new Database();
$api = new APIGateway($db);
$api->handleRequest();
