<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
class Employee {
    private $database;
    private $table_name_1 = "Employee";
    private $table_name_2 = "Salary";

    public $accountID;
    public $name;
    public $level;
    public $position;
    public $salary;
    public $username;
    public $startdate;
    public $managedBy;

    public function __construct($db) {
        $this->database = $db;
    }

    function read() {
        $query = "SELECT * FROM " . $this->table_name_1;
        $stmt = $this->database->executePlainSQL($query);

        return $stmt;
    }

    function fetchAllEmployeeUsername() {
        $query = "SELECT accountID, username, name FROM " . $this->table_name_1;
        $stmt = $this->database->executePlainSQL($query);

        return $stmt;
    }

    // select accountid, e.username, e.name, e.emp_level, e.emp_type, e.starting_date, e.managed_by, s.salary 
    // from Employee e, Salary s 
    // where e.emp_level=s.emp_level and e.emp_type=s.emp_type;

    function getEmployeeInfo() {
        $query = "SELECT accountid, e.username, e.name, e.emp_level, e.emp_type, e.starting_date, e.managed_by, s.salary FROM " . 
        $this->table_name_1 . " e, " . $this->table_name_2 . " s" . 
        " WHERE accountID = " . $this->accountID . " AND " . 
        "e.emp_level=s.emp_level and e.emp_type=s.emp_type";
        $stmt = $this->database->executePlainSQL($query);

        return $stmt;
    }

    function addEmployee() {
        $query = "INSERT INTO " . $this->table_name_1 . 
            " (name, emp_level, emp_type, starting_date, managed_by, username) VALUES ('" . 
            $this->name . "', '" . $this->level . "', '" . $this->position . "', DATE '" . $this->startdate . "', " . 
            $this->managedBy . ", '" . $this->username . "')";
        $stmt = $this->database->executePlainSQL($query);

        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }

    function editEmployee() {
        $query = "UPDATE " . $this->table_name_1 . " SET emp_type = '" . $this->position . 
            "', emp_level = '" . $this->level . "' WHERE username = '" . $this->username . "'";
        $stmt = $this->database->executePlainSQL($query);

        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }

    function editPosition() {
        $query = "UPDATE " . $this->table_name_1 . 
        " SET type = " . $this->position . 
        " WHERE username = " . $this->username;
        $stmt = $this->database->executePlainSQL($query);

        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }

    function editLevel() {
        $query = "UPDATE " . $this->table_name_1 . 
        " SET level = " . $this->level . 
        " WHERE username = " . $this->username;
        $stmt = $this->database->executePlainSQL($query);

        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }

    function editSalary() {
        $query = "UPDATE " . $this->table_name_1 . 
        " SET salary = " . $this->salary . 
        " WHERE username = " . $this->username;
        $stmt = $this->database->executePlainSQL($query);

        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }

    function editName() {
        $query = "UPDATE " . $this->table_name_1 . 
        " SET name = " . $this->name . 
        " WHERE username = " . $this->username;
        $stmt = $this->database->executePlainSQL($query);

        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }

    function createEmployee() {
        $query = "INSERT INTO " . $this->table_name_1 . 
            " (accountID, name, level, type, salary, username, startdate) VALUES ('" . 
            $this->accountID . "', '" . $this->name . "', '" . $this->level . "', '" . 
            $this->position . "', '" . $this->salary . "', '" . $this->username . "', '" . $this->startdate . "')";
        $stmt = $this->database->executePlainSQL($query);

        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }
}
?>
