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
include_once "../objects/horse.php";

$database = new Database();
$db = $database->connectToDB();

// Instantiate new horse object
$horse = new Horse($database);

// Decode provided data
$data = json_decode(file_get_contents('php://input'), true);

// Instantiate addition data
$horse->horseID = $data['horseid'];
$horse->nickname = $data['nickname'];
$horse->age = $data['age'];
$horse->breed = $data['breed'];
$horse->odds = $data['odds'];
$horse->jockeyID = $data['jockeyid'];
$horse->numraces = $data['numraces'];

//Attemp adding horse 
if (!$horse->addHorse()) {
    http_response_code(500);
    echo json_encode(array("message" => "Error creating a horse with given credentials."));
    die();
}

http_response_code(200);

echo json_encode(array("message" => "Successfully Added."));

$database->disconnectFromDB();
?>