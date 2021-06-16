<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";
include_once "../objects/employee.php";
include_once "../objects/users.php";

$database = new Database();
$db = $database->connectToDB();

// Instantiate new employee object
$employee = new Employee($database);

$user = new User($database);

// Decode provided data
$data = json_decode(file_get_contents('php://input'), true);

// Instantiate addition data
$employee->username = $data['username'];
$employee->name = $data['name'];
$employee->level = $data['emp_level'];
$employee->position = $data['emp_type'];
$employee->startdate = $data['starting_date'];
$employee->managedBy = $data['managed_by'];

$user->username = $data['username'];
$user->password = "password";

if(!$user->createUser()) {
    http_response_code(500);
    echo json_encode(array("message" => "Error creating user with given credentials."));
    die();
}

//Attemp adding employee 
if (!$employee->addEmployee()) {
    http_response_code(500);
    echo json_encode(array("message" => "Error creating user with given credentials."));
    die();
}

http_response_code(200);

echo json_encode(array("message" => "Successfully Added."));

$database->disconnectFromDB();
?>