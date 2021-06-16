<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
class User {
    private $database;
    private $table_name = "Users";

    public $username;
    public $password;

    public function __construct($db) {
        $this->database = $db;
    }

    function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = " . $this->username . " AND password = " . $this->password;
        $stmt = $this->database->executePlainSQL($query);

        return $stmt;
    }

    function createUser() {
        $query = "INSERT INTO " . $this->table_name . " VALUES ('" . $this->username . "', '" . $this->password . "')";
        $stmt = $this->database->executePlainSQL($query);
        
        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteUser() {
        $query = "DELETE FROM " . $this->table_name . " WHERE username = " . $this->username;
        $stmt = $this->database->executePlainSQL($query);
        
        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }
}
?>
