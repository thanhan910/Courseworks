<?php
class HitCounter {
    private $conn;
    private $table;

    function __construct($host, $username, $password, $dbname, $tablename) {
        $this->table = $tablename;

        $this->conn = new mysqli($host, $username, $password, $dbname);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getHits() {
        $sql = "SELECT hits FROM $this->table WHERE id = 1";
        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["hits"];
        } else {
            return 0;
        }
    }

    public function setHits() {
        $currentHits = $this->getHits();
        $newHits = $currentHits + 1;
        
        $sql = "UPDATE $this->table SET hits = $newHits WHERE id = 1";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function closeConnection() {
        $this->conn->close();
    }

    public function startOver() {
        $sql = "UPDATE $this->table SET hits = 0 WHERE id = 1";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}
?>
