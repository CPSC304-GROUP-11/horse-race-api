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
include_once "../objects/users.php";
include_once "../objects/customer.php";
include_once "../objects/membership.php";

$database = new Database();
$db = $database->connectToDB();

// Instantiate required objects for new customer
$user = new User($database);
$customer = new Customer($database);
$member = new Membership($database);

// Decode provided data
$data = json_decode(file_get_contents('php://input'), true);

// Set properties of user
$user->username = $data['username'];
$user->password = $data['password'];

// Create user; if failure, send message and exit
if (!$user->createUser()) {
    http_response_code(500);
    echo json_encode(array("message" => "Error creating user with given credentials."));
    die();
}

// Set properties of member
$member->fee = $data['fee'];
$member->standing = 'Valid';
$member->type = $data['type'];

// Create member; if failure, send message and exit
if (!$member->createMember()) {
    http_response_code(500);
    echo json_encode(array("message" => "Error creating membership with given fields."));
    die();
}

$stmt = $member->fetchLastMember();

if (oci_fetch($stmt)) {
    $member->memberID = oci_result($stmt, 'MEMBERID');
}

// Set properties of customer
$customer->name = $data['name'];
$customer->balance = 0;
$customer->address = $data['address'];
$customer->memberID = $member->memberID;
$customer->username = $data['username'];

// Create customer; if failure, send message and exit
if (!$customer->createCustomer()) {
    http_response_code(500);
    echo json_encode(array("message" => "Error creating customer with given fields."));
    die();
}

// Upon creation of all required entities, send status code 201
http_response_code(201);
echo json_encode(array("message" => "Customer creation successful."));

$database->disconnectFromDB();
?>
