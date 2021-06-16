<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/race.php";

$database = new Database();
$db = $database->connectToDB();

// Instantiate new race object
$race = new Race($database);

// Instantiate raceID
$race->raceID = $_GET['raceid'];

// Attempt fetching all customers
$stmt = $race->getRaceInfo();
$nrows = oci_fetch_all($stmt, $res);

// Instantiate records array and push customer objects using loop
if ($nrows > 0) {
    $race_array = array();
    $race_array["records"] = array();

    for ($i = 0; $i < $nrows; $i++) {
        $customer_i = array(
            "raceid" => $res["RACEID"][$i],
            "horseid" => $res["HORSEID"][$i],
            "nickname" => $res["NICKNAME"][$i],
            "rank" => $res["RANK"][$i],
            "odds" => $res["ODDS"][$i],
            "number_of_races" => $res["NUMBER_OF_RACES"][$i],
            "age" => $res["AGE"][$i],
        );

        array_push($race_array["records"], $customer_i);
    }

    oci_free_statement($stmt);

    http_response_code(200);

    echo json_encode($race_array);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No customers found.")
    );
}

$database->disconnectFromDB();
?>
