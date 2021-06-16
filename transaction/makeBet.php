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
include_once "../objects/bet.php";

$database = new Database();
$db = $database->connectToDB();

// Instantiate new bet object
$bet = new bet($database);

// Decode provided data
$data = json_decode(file_get_contents('php://input'), true);

// Instantiate transaction data
$bet->horseID = $data['horseid'];
$bet->accountID = $data['accountid'];
$bet->amount = $data['amount'];
$bet->betType = $data['bettype'];
$bet->raceID = $data['raceid'];


if (!$bet->insertBetToPlace_bets_on()) {
    http_response_code(500);
    echo json_encode(array("message" => "Error creating inserting a bet."));
    die();
} else {
    $stmt = $bet->fetchLastBetID();
    $res = oci_fetch_assoc($stmt);
    if($res != false){
        $bet->betID = $res["BETID"];
       if(!$bet->insertBetToBets_in_race()){
            http_response_code(500);
            echo json_encode(array("message" => "Error creating inserting a bet into a race."));
            die();
        }
        else {
            // Upon creation of all required entities, send status code 201
            http_response_code(201);
            echo json_encode(array("message" => "Bet creation successful."));
        }
    }
}


$database->disconnectFromDB();
?>