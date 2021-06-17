<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
class Jockey {
    private $database;
    private $table_name_1 = "JOCKEY_MEMBEROF";
    private $table_name_2 = "HORSECLUB";
    private $table_name_3 = "HORSE_RIDDEN_BY";
    
    public $jockeyID;
    public $name;
    public $yoe;
    public $club;

    public function __construct($db) {
        $this->database = $db;
    }

    //select j.jockeyid, j.YEARS_OF_EXP, j.NAME, HORSE_CLUB_ID, count(*) num_of_horse_ridden from HORSE_RIDDEN_BY h, JOCKEY_MEMBEROF j where h.jockeyid=j.jockeyid GROUP BY j.jockeyid, j.YEARS_OF_EXP, j.NAME, HORSE_CLUB_ID ORDER BY J.JOCKEYID;
    function read() {
        $query = "SELECT j.jockeyid, j.YEARS_OF_EXP, j.NAME, HORSE_CLUB_ID, count(*) num_of_horse_ridden FROM " . 
        $this->table_name_1 . " j INNER JOIN " . $this->table_name_3 . " h" . 
        " ON h.jockeyid=j.jockeyid GROUP BY j.jockeyid, j.YEARS_OF_EXP, j.NAME, HORSE_CLUB_ID ORDER BY J.JOCKEYID";
        $stmt = $this->database->executePlainSQL($query);

        return $stmt;
    }

    //select j.jockeyid, j.years_of_exp, j.name jockeyName, h.name clubName from JOCKEY_MEMBEROF j, HORSECLUB h where j.horse_club_id=h.horse_club_id;
    function getJockeyInfo() {
        $query = "SELECT j.jockeyid, j.years_of_exp, j.name jockeyName, h.name clubName FROM " . $this->table_name_1 . " j INNER JOIN " . $this->table_name_2 . " h"
        . " ON jockeyID = " . $this->jockeyID . " AND j.horse_club_id=h.horse_club_id";

        $stmt = $this->database->executePlainSQL($query);

        return $stmt;
    }

    function addJockey() {
        $query = "INSERT INTO " . $this->table_name_1 . 
            " (jockeyID, name, yoe, club) VALUES ('" . 
            $this->jockeyID . "', '" . $this->name . "', '" . $this->yoe . "', '" . $this->club . "')";
        $stmt = $this->database->executePlainSQL($query);

        return $stmt;
    }

    function createJockey() {
        $query = "INSERT INTO " . $this->table_name_1 . 
            " (jockeyID, name, yoe, club) VALUES ('" . 
            $this->jockeyID . "', '" . $this->name . "', '" . $this->yoe . "', '" . $this->club . "')";
        $stmt = $this->database->executePlainSQL($query);

        if (OCICommit($this->database->conn)) {
            return true;
        } else {
            return false;
        }
    }
}
?>
