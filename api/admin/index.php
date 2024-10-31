<?php

require_once '../config/Database.php'; // Include your database connection
require_once 'course.php';
// require_once 'professor.php';
// require_once 'department.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");


class AdminAPI
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

    public function handleRequest()
    {
        if (count($this->params) < 3) {
            http_response_code(400);
            echo json_encode(["message" => "Bad Request", "success" => false]);
            return;
        }

        $entity = $this->params[2];
        $id = isset($this->params[3]) ? $this->params[3] : null;

        switch ($entity) {
            case 'course':
                $controller = new CourseController($this->db);
                break;
            /* case 'professor':
                $controller = new ProfessorController($this->db);
                break;
            case 'department':
                $controller = new DepartmentController($this->db);
                break; */
            default:
                http_response_code(404);
                echo json_encode(["message" => "Not Found", "success" => false]);
                return;
        }

        switch ($this->method) {
            case 'GET':
                if ($id) {                  
                  $controller->fetchById($id);
                } else {
                    $controller->fetchAll();
                }
                break;
                
            case 'POST':
                $controller->insert();
                break;
             case 'PUT':
                if ($id) {
                    $controller->update($id);
                } else {
                    http_response_code(400);
                    echo json_encode(["message" => "Bad Request", "success" => false]);
                }
                break;
            case 'DELETE':
                if ($id) {
                    $controller->delete($id);
                } else {
                    http_response_code(400);
                    echo json_encode(["message" => "Bad Request", "success" => false]);
                }
                break; 
            default:
                http_response_code(405);
                echo json_encode(["message" => "Method Not Allowed", "success" => false]);
                break;
        }
    }
}

$db = new Database();
$api = new AdminAPI($db);
$api->handleRequest();