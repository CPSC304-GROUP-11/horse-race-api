<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/employee.php";

$database = new Database();
$db = $database->connectToDB();

// Instantiate new employee object
$employee = new Employee($database);

// Attempt fetching all employees
$stmt = $employee->fetchAllEmployeeUsername();
$nrows = oci_fetch_all($stmt, $res);

// Instantiate records array and push customer objects using loop
if ($nrows > 0) {
    $employees_arr = array();
    $employees_arr["records"] = array();

    for ($i = 0; $i < $nrows; $i++) {
        $employee_i = array(
            "accountID" => $res["ACCOUNTID"][$i],
            "username" => $res["USERNAME"][$i],
            "name" => $res["NAME"][$i]
        );

        array_push($employees_arr["records"], $employee_i);
    }

    oci_free_statement($stmt);

    http_response_code(200);

    echo json_encode($employees_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No employees found.")
    );
}

$database->disconnectFromDB();
?>