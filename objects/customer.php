<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
class Customer {
    private $database;
    private $table_name = "Customer";
    
    public $accountID;
    public $name;
    public $balance;
    public $address;
    public $memberID;
    public $username;

    public function __construct($db) {
        $this->database = $db;
    }

    function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->database->executePlainSQL($query);

        return $stmt;
    }

    function getCustomerInfo() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = " . $this->username;
        $stmt = $this->database->executePlainSQL($query);

        return $stmt;
    }

    function addFund() {
        $query = "UPDATE " . $this->table_name . 
        " SET balance = balance + " . $this->fund . 
        " WHERE username = '" . $this->username . "'";
        $stmt = $this->database->executePlainSQL($query);

        return $stmt;
    }

    function createCustomer() {
        $query = "INSERT INTO " . $this->table_name . 
            " (name, balance, address, memberID, username) VALUES ('" . 
            $this->name . "', '" . $this->balance . "', '" . 
            $this->address . "', '" . $this->memberID . "', '" . $this->username . "')";
        $stmt = $this->database->executePlainSQL($query);

        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }
}
?>
