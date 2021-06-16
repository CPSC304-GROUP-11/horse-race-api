<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/customer.php";

$database = new Database();
$db = $database->connectToDB();

// Instantiate new customer object
$customer = new Customer($database);

// Instantiate customer's username
// TODO: change this to accountID
$customer->username = $_GET['username'];

// Attempt fetching single customers
$stmt = $customer->getCustomerInfo();
$res = oci_fetch_assoc($stmt);

// Instantiate records array and push customer objects using loop
if ($res != false) {
    $customer_data = array(
        "accountID" => $res["ACCOUNTID"],
        "name" => $res["NAME"],
        "balance" => $res["BALANCE"],
        "address" => $res["ADDRESS"],
        "memberID" => $res["MEMBERID"],
        "username" => $res["USERNAME"]
    );

    oci_free_statement($stmt);

    http_response_code(200);

    echo json_encode($customer_data);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No customers found.")
    );
}

$database->disconnectFromDB();
?>