<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "db_blackcinema";
    public $conn;

    public function __construct() {
        try {
            // 1. Connect tanpa db dulu, buat db kalau belum ada
            $tempConn = new PDO("mysql:host=$this->host", $this->username, $this->password);
            $tempConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $tempConn->exec("CREATE DATABASE IF NOT EXISTS $this->dbname");

            // 2. Connect ke database yang baru dibuat
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // 3. Cek apakah tabel sudah ada (opsional, untuk hindari duplikasi)
            $stmt = $this->conn->query("SHOW TABLES LIKE 'Movies'");
            if ($stmt->rowCount() === 0) {
                // 4. Import file SQL kalau belum ada tabel
                $this->importSQL(__DIR__ . '/../database/schema.sql');
            }
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    private function importSQL($filepath) {
        try {
            $sql = file_get_contents($filepath);
            $this->conn->exec($sql);
        } catch (PDOException $e) {
            die("Failed to import SQL: " . $e->getMessage());
        }
    }
}
?>