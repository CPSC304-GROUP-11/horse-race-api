<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once "../config/database.php";
include_once "../objects/horse.php";

$database = new Database();
$db = $database->connectToDB();

// Instantiate new horse object
$horse = new Horse($database);

$horse->horseID = $_GET['horseID'];

if(!$horse->deleteHorse()) {
    http_response_code(500);
    echo json_encode(array("message" => "Error deleting horse with given credentials."));
    die();
}

http_response_code(200);

echo json_encode(array("message" => "Successfully Added."));

$database->disconnectFromDB();
?>