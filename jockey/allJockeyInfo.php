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

// Attempt fetching all employees
$stmt = $jockey->read();
$nrows = oci_fetch_all($stmt, $res);

// Instantiate records array and push customer objects using loop
if ($nrows > 0) {
    $jockeys_arr = array();
    $jockeys_arr["records"] = array();

    for ($i = 0; $i < $nrows; $i++) {
        $jockeys_i = array(
            "jockeyid" => $res["JOCKEYID"][$i],
            "years_of_exp" => $res["YEARS_OF_EXP"][$i],
            "name" => $res["NAME"][$i],
            "horse_club_id" => $res["HORSE_CLUB_ID"][$i],
            "num_of_horse_ridden" => $res["NUM_OF_HORSE_RIDDEN"][$i]
        );

        array_push($jockeys_arr["records"], $jockeys_i);
    }

    oci_free_statement($stmt);

    http_response_code(200);

    echo json_encode($jockeys_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No jockeys found.")
    );
}

$database->disconnectFromDB();
?>