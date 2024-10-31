<?php
class Logout {
  public function __construct() {
    session_start();
    $this->clearSession();
    $this->destroySession();
    $this->sendResponse();
  }

  private function clearSession() {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
      );
    }
  }

  private function destroySession() {
    session_destroy();
  }

  private function sendResponse() {
    echo json_encode(["message" => "You Logged out SUCCESSFULLY"]);
    exit();
  }
}

