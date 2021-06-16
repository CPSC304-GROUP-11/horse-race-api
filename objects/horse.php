<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
class Horse {
    private $database;
    private $table_name = "Horse_ridden_by";
    
    public $horseID;
    public $nickname;
    public $age;
    public $breed;
    public $odds;
    public $jockeyID;
    public $numraces;

    public function __construct($db) {
        $this->database = $db;
    }

    function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->database->executePlainSQL($query);

        return $stmt;
    }

    // modify this to join membership table
    function getHorseInfo() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = " . $this->username;
        $stmt = $this->database->executePlainSQL($query);

        return $stmt;
    }

    function addHorse() {
        $query = "INSERT INTO " . $this->table_name . 
            " (horseID, nickname, age, breed, odds, numraces, jockeyID) VALUES ('" . 
            $this->horseID . "', '" . $this->nickname . "', '" . $this->age . "', '" . 
            $this->breed . "', '" . $this->odds . "', '" . $this->numraces . "', '" . $this->jockeyID . "')";
        $stmt = $this->database->executePlainSQL($query);

        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }

    function editOdds() {
        $query = "UPDATE " . $this->table_name . 
        " SET odds = " . $this->odds . 
        " WHERE horseID = " . $this->horseID;
        $stmt = $this->database->executePlainSQL($query);

        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }

    function createHorse() {
        $query = "INSERT INTO " . $this->table_name . 
            " (horseID, nickname, age, breed, odds, numraces, jockeyID) VALUES ('" . 
            $this->horseID . "', '" . $this->nickname . "', '" . $this->age . "', '" . 
            $this->breed . "', '" . $this->odds . "', '" . $this->numraces . "', '" . $this->jockeyID . "')";
        $stmt = $this->database->executePlainSQL($query);

        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }
}
?>
