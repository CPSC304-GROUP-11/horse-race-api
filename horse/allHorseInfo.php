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

// Attempt fetching all employees
$stmt = $horse->read();
$nrows = oci_fetch_all($stmt, $res);

// Instantiate records array and push customer objects using loop
if ($nrows > 0) {
    $horses_arr = array();
    $horses_arr["records"] = array();

    for ($i = 0; $i < $nrows; $i++) {
        $horses_i = array(
            "horseID" => $res["HORSEID"][$i],
            "nickname" => $res["NICKNAME"][$i],
            "odds" => $res["ODDS"][$i],
            "breed" => $res["BREED"][$i],
            "number_of_races" => $res["NUMBER_OF_RACES"][$i],
            "age" => $res["AGE"][$i],
            "jockeyID" => $res["JOCKEYID"][$i]
        );

        array_push($horses_arr["records"], $horses_i);
    }

    oci_free_statement($stmt);

    http_response_code(200);

    echo json_encode($horses_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No employees found.")
    );
}

$database->disconnectFromDB();
?>