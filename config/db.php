<?php
// ============================================================
//  config/db.php  –  Database connection (MySQLi)
// ============================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');          // Change for production
define('DB_PASS', '');              // Change for production
define('DB_NAME', 'firewatch_db1');
define('DB_PORT', 3306);

function getDB(): mysqli  
{
    static $conn = null;
    if ($conn !== null) {
        return $conn;
    }

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    if ($conn->connect_error) {
        http_response_code(503);
        die(json_encode([
            'error' => 'Database connection failed: ' . $conn->connect_error
        ]));
    }

    $conn->set_charset('utf8mb4');
    return $conn;
}