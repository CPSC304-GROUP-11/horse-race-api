<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/horse.php";

$database = new Database();
$db = $database->connectToDB();

// Instantiate new horse object
$horse = new Horse($database);

// Instantiate horseID
$horse->horseID = $_GET['horseid'];

// Attempt fetching a single horse info
$stmt = $horse->getHorseInfo();
$res = oci_fetch_assoc($stmt);

// Instantiate records array and push horse into an object
if ($res != false) {
    $horse_data = array(
        "horseID" => $res["HORSEID"],
        "nickename" => $res["NICKNAME"],
        "odds" => $res["ODDS"],
        "breed" => $res["BREED"],
        "number_of_races" => $res["NUMBER_OF_RACES"],
        "age" => $res["AGE"],
        "jockeyID" => $res["JOCKEYID"]
    );

    oci_free_statement($stmt);

    http_response_code(200);

    echo json_encode($horse_data);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No horse found.")
    );
}

$database->disconnectFromDB();
?>