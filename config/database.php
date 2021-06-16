<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");

class Database {
    private $username = "ora_enxie";
    private $password = "a47605134";
    private $hostname = "dbhost.students.cs.ubc.ca:1522/stu";
    public $conn = NULL;

    public function connectToDB() {
        $this->conn = OCILogon($this->username, $this->password, $this->hostname);

        if (!$this->conn) {
            $e = OCI_Error();
            echo "<script type='text/javascript'>alert('" . $e . "');</script>";
        }
        
        return $this->conn;
    }

    public function disconnectFromDB() {
        OCILogoff($this->conn);
    }

    public function executePlainSQL($qrystr) {
        $stmt = OCIParse($this->conn, $qrystr);

        if (!$stmt) {
            echo "<p>Error parsing the command: " . $qrystr . "</p>";
            $e = OCI_Error($this->conn);
            echo "<script type='text/javascript'>alert('" . $e["message"] . "');</script>";
        }

        $r = OCIExecute($stmt);

        if (!$r) {
            echo "<p>Error executing the command: " . $qrystr . "</p>";
            $e = OCI_Error($stmt);
            echo "<script type='text/javascript'>alert('" . $e["message"] . "');</script>";
        }

        return $stmt;
    }
}
?>
