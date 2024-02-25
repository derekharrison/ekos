<?php

class Database {

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "ekos_dp";

    function connect() {
        return mysqli_connect($this->host, $this->username, $this->password, $this->db);
    }
    
    function read($query) {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if(!$result) {
            return false;
        }
        else {
            $data = false;
            while($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }         
            
            return $data;
        }
    }
    
    function save($query) {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if(!$result) {
            return false;
        }
        else {
            return true;
        }
    }
}