<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";
include_once "../objects/user.php";
include_once "../objects/customer.php";
include_once "../objects/membership.php";

$database = new Database();
$db = $database->connectToDB();

// Instantiate required objects for new customer
$user = new User($database);
$customer = new Customer($database);
$member = new Membership($database);

// Decode provided data
$data = json_decode(file_get_contents("php://input"));

// Set properties of user first
$user->username = $data->username;
$user->password = $data->password;

// Create user; if failure, send message and exit
if (!$user->createUser()) {
    http_response_code(500);
    echo json_encode(array("message" => "Error creating user with given credentials."));
    die();
}

$member->memberID = $data->memberID;
$member->fee = $data->fee;
$member->standing = 'Valid';
$member->type = $data->type;

if (!$member->createMember()) {
    http_response_code(500);
    echo json_encode(array("message" => "Error creating user with given credentials."));
    die();
}

$this->database->disconnectFromDB();
?>
