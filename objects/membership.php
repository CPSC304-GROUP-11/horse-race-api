<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
class Membership {
    private $database;
    private $table_name = "Membership";

    public $memberID;
    public $fee;
    public $standing;
    public $type;

    public function __construct($db) {
        $this->database = $db;
    }

    function createMember() {
        $query = "INSERT INTO " . $this->table_name . 
            " (fee, standing, type) VALUES (" . 
            $this->fee . ", '" . $this->standing . "', '" . $this->type . "')";
        $stmt = $this->database->executePlainSQL($query);

        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }

    function fetchLastMember() {
        $query = "SELECT memberID FROM " . $this->table_name . 
            " WHERE memberID = (SELECT MAX(memberID) FROM " . $this->table_name . " )";
        $stmt = $this->database->executePlainSQL($query);

        return $stmt;
    }
}
?>
