<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/jockey.php";

$database = new Database();
$db = $database->connectToDB();

// Instantiate new jockey object
$jockey = new Jockey($database);

// Instantiate jockeyID
$jockey->jockeyID = $_GET['jockeyid'];

// Attempt fetching a single jockey info
$stmt = $jockey->getJockeyInfo();
$res = oci_fetch_assoc($stmt);

// Instantiate records array and push horse into an object
if ($res != false) {
    $horse_data = array(
        "horseID" => $res["JOCKEYID"],
        "years_of_exp" => $res["YEARS_OF_EXP"],
        "jName" => $res["JOCKEYNAME"],
        "hName" => $res["CLUBNAME"],
    );

    oci_free_statement($stmt);

    http_response_code(200);

    echo json_encode($horse_data);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No jockey found.")
    );
}

$database->disconnectFromDB();
?>