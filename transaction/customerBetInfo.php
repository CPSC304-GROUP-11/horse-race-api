<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/bet.php";

$database = new Database();
$db = $database->connectToDB();

// Instantiate new bet object
$bet = new Bet($database);

// Instantiate customer's accountID
$bet->accountID = $_GET['accountid'];

// Attempt fetching all customers
$stmt = $bet->getBetAllInfo();
$nrows = oci_fetch_all($stmt, $res);

// Instantiate records array and push customer objects using loop
if ($nrows > 0) {
    $customers_bet_info = array();
    $customers_bet_info["records"] = array();

    for ($i = 0; $i < $nrows; $i++) {
        $customer_i = array(
            "betID" => $res["BETID"][$i],
            "horseID" => $res["HORSEID"][$i],
            "nickname" => $res["NICKNAME"][$i],
            "accountID" => $res["ACCOUNTID"][$i],
            "amount" => $res["AMOUNT"][$i],
            "bet_date" => $res["BET_DATE"][$i],
            "bet_type" => $res["BET_TYPE"][$i]
        );

        array_push($customers_bet_info["records"], $customer_i);
    }

    oci_free_statement($stmt);

    http_response_code(200);

    echo json_encode($customers_bet_info);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No customers found.")
    );
}

$database->disconnectFromDB();
?>
