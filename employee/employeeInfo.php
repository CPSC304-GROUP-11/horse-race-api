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

// Instantiate emloyee's accountID
$employee->accountID = $_GET['accountid'];

// Attempt fetching a single employee info
$stmt = $employee->getEmployeeInfo();
$res = oci_fetch_assoc($stmt);

// Instantiate records array and push employee into an object
if ($res != false) {
    $employee_data = array(
        "accountID" => $res["ACCOUNTID"],
        "name" => $res["NAME"],
        "emp_level" => $res["EMP_LEVEL"],
        "emp_type" => $res["EMP_TYPE"],
        "starting_date" => $res["STARTING_DATE"],
        "salary" => $res["SALARY"],
        "managed_by" => $res["MANAGED_BY"],
        "username" => $res["USERNAME"]
    );

    oci_free_statement($stmt);

    http_response_code(200);

    echo json_encode($employee_data);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No employees found.")
    );
}

$database->disconnectFromDB();
?>