<?php
class Database {
    private static $host = "localhost";
    private static $user = "root";
    private static $password = "";
    private static $dbname = "inventory_db";
    private static $conn;

    public static function connect() {
        if (!isset(self::$conn)) {
            self::$conn = new mysqli(self::$host, self::$user, self::$password, self::$dbname);
            if (self::$conn->connect_error) {
                die("Koneksi gagal: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
}
?>
