<?php
include_once "../../config/Database.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

class ProfessorController
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
            default:
                echo json_encode(array("message" => "Invalid request", "success" => false));
                break;
        }
    }

    private function fetch()
    {
        try {
            $retrieve = "SELECT 
                          professor.*, 
                          (DATE_FORMAT(FROM_DAYS(DATEDIFF(now(), professor.birth_date)), '%Y')+0) AS age, 
                          department.name AS dept_name, 
                          GROUP_CONCAT(professor_phone.phone_number SEPARATOR ' | ') AS phone
                        FROM 
                          professor
                        LEFT JOIN 
                          professor_phone ON professor.id = professor_phone.professor_id
                        INNER JOIN 
                          department ON professor.department_id = department.id
                        GROUP BY 
                          professor.id";

            $stmt = $this->conn->prepare($retrieve);
            $stmt->execute();
            $result = $stmt->get_result();

            $records = array();

            while ($row = $result->fetch_assoc()) {
                $records[] = array(
                    "id" => htmlspecialchars($row["id"]),
                    "first_name" => htmlspecialchars($row["first_name"]),
                    "last_name" => htmlspecialchars($row["last_name"]),
                    "gender" => htmlspecialchars($row["gender"]),
                    "email" => htmlspecialchars($row["email"]),
                    "birth" => htmlspecialchars($row["birth_date"]),
                    "age" => htmlspecialchars($row["age"]),
                    "city" => htmlspecialchars($row["city"]),
                    "street" => htmlspecialchars($row["street"]),
                    "department" => htmlspecialchars($row["dept_name"]),
                    "phone" => htmlspecialchars($row["phone"])
                );
            }

            echo json_encode(["data" => $records, "success" => true]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo json_encode(["error" => "An error occurred while fetching data."]);
        }
    }
}

// Initialize the database and controller
$db = new Database();
$controller = new ProfessorController($db);
$controller->handleRequest();