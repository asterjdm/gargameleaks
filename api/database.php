<?php

class Database
{
    private $conn;
    
    public function __construct()
    {
        include_once(dirname(__FILE__) . "/secrets.php");
        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function select($sql_prompt)
    {
        $result = $this->conn->query($sql_prompt);

        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    public function query($sql_prompt)
    {
        $result = $this->conn->query($sql_prompt);

        if (!$result) {
            die("Query failed: " . $this->conn->error);
        }

        return $result;
    }

    public function closeConnection()
    {
        $this->conn->close();
    }

    public function escapeStrings($str)
    {
        return $this->conn->real_escape_string($str);
    }
}
?>
