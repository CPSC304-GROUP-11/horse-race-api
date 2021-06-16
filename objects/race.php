<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
class Race {
    private $database;
    private $table_name_1 = "Race_heldAt";
    private $table_name_2 = "Stadium";
    private $table_name_3 = "Rides_in_race";
    private $table_name_4 = "Horse_ridden_by";

    public function __construct($db) {
        $this->database = $db;
    }

    public $raceID;

    function getStadiumInfo() {
        $query = "SELECT RACEID, s.NAME, STADIUMADDR, RACE_TYPE, RACE_DATE FROM " . 
        $this->table_name_1 . " r, " . $this->table_name_2 . " s " . 
        "WHERE r.STADIUMADDR = s.ADDRESS";

        $stmt = $this->database->executePlainSQL($query);
        return $stmt;
    }

    function getRaceInfo() {
        $query = "SELECT RACEID, r.HORSEID, NICKNAME, r.RANK, ODDS, NUMBER_OF_RACES, AGE FROM " . 
        $this->table_name_3 . " r, " . $this->table_name_4 . " h " . 
        "WHERE r.RACEID=" . $this->raceID . " AND r.HORSEID=h.HORSEID";

        $stmt = $this->database->executePlainSQL($query);
        return $stmt;
    }
}
?>