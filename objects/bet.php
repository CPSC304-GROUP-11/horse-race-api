<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
class Bet {
    private $database;
    private $table_name_1 = "Place_bets_on";
    private $table_name_2 = "Horse_ridden_by";
    private $table_name_3 = "Bets_in_race";

    public function __construct($db) {
        $this->database = $db;
    }

    public $accountID;
    public $raceID;
    public $horseID;
    public $amount;
    public $betType;
    public $betID;

    function getBetAllInfo() {
        $query = "SELECT BETID, p.HORSEID, NICKNAME, ACCOUNTID, AMOUNT, BET_DATE, BET_TYPE FROM " . 
        $this->table_name_1 . " p, " . $this->table_name_2 . " h" . 
        " WHERE p.ACCOUNTID = " . $this->accountID . " AND " . 
        "p.HORSEID=h.HORSEID";
        $stmt = $this->database->executePlainSQL($query);
        return $stmt;
    }

    // select the bets in the past 7 days
    function getRecentBetInfo() {
        $query = "SELECT BETID, p.HORSEID, NICKNAME, ACCOUNTID, AMOUNT, BET_DATE, BET_TYPE FROM " . 
        $this->table_name_1 . " p, " . $this->table_name_2 . " h" . 
        " WHERE p.ACCOUNTID = " . $this->accountID . " AND " . 
        "p.HORSEID=h.HORSEID AND BET_DATE > (SYSDATE - 7)";
        $stmt = $this->database->executePlainSQL($query);
        return $stmt;
    }

    function insertBetToPlace_bets_on() {
        $query = "INSERT INTO " . $this->table_name_1 . 
        " (HORSEID, ACCOUNTID, AMOUNT, BET_DATE, BET_TYPE) VALUES (" . 
        $this->horseID . ", " . $this->accountID . ", " . $this->amount . ", " . 
        "SYSDATE, " . $this->betType . ")";

        $stmt = $this->database->executePlainSQL($query);
        
        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }

    // select the last bets based on the account id
    //select BETID from PLACE_BETS_ON where BETID = (select MAX(BETID) from PLACE_BETS_ON WHERE accountid=1); 
    function fetchLastBetID() {
        $query = "SELECT BETID FROM " . $this->table_name_1 . 
        " WHERE BETID = (select MAX(BETID) FROM " . $this->table_name_1 . 
        " WHERE ACCOUNTID=" . $this->accountID . ")";

        $stmt = $this->database->executePlainSQL($query);
        return $stmt;
    }

    function insertBetToBets_in_race() {
        $query = "INSERT INTO " . $this->table_name_3 . 
        " (BETID, RACEID) VALUES (" .
        $this->betID . ", " . $this->raceID . ")";

        $stmt = $this->database->executePlainSQL($query);
        
        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }

}
?>