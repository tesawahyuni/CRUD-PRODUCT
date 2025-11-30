<?php
class Database {
    private $host = "localhost";
    private $db   = "crud_produk";
    private $user = "root";
    private $pass = "";
    private $conn;

    public function connect() {
        if ($this->conn == null) {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db}",
                $this->user,
                $this->pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        }
        return $this->conn;
    }
}
?>
