<?php
class Employee
{
    // Connection
    private $conn;
    // Table
    private $db_table = "bilet";
    // Columns
    public $id;
    public $type;
    public $sell;
    public $kolvo;
    public $itog;


    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getEmployees()
    {
        $sqlQuery = "SELECT id, type, sell, kolvo, itog FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

}
?>