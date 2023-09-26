<?php
/**
 * Description of Database
 *
 * @author Zunayed Hassan
 */
require_once __DIR__ . "/Settings.php";

class Database {
    private $_mysqli = null;

    public function __construct() {
        try {
            $this->_mysqli = new mysqli(Settings::$DB_SERVER_NAME, Settings::$DB_USER_NAME, Settings::$DB_PASSWORD, Settings::$DB_NAME);
            $this->_mysqli->set_charset("utf8mb4");
        }
        catch (Exception $exception) {
            error_log($exception->getMessage());
            echo("Error connecting to database");
        }
    }
    
    public function GetConncetion() {
        return $this->_mysqli;
    }
    
    public function GetQueryResult($sql) {
        $result = $this->GetQueryResults($sql);
        
        if ($result == null) {
            return null;
        }
        else if (count($result) == 0) {
            return null;
        }
        
        return $this->GetQueryResults($sql)[0];
    }
    
    public function GetQueryResults($sql) {
        $results = $this->GetConncetion()->query($sql);
        
        if (($results == null) || ($results->num_rows == 0)) {
            return null;
        }
        
        $rows = array();
        
        while ($row = $results->fetch_assoc()) {
            array_push($rows, $row);
        }
        
        return $rows;
    }
    
    public function Insert($sql) {
        $lastInsertedID = null;
        
        if ($this->_mysqli->query($sql)) {
            $lastInsertedID = $this->GetConncetion()->insert_id;
        }
        
        return $lastInsertedID;
    }
    
    public function Delete($sql) {
        return $this->_mysqli->query($sql);
    }
    
    public function Update($sql) {
        $this->_mysqli->query($sql);
    }
}
