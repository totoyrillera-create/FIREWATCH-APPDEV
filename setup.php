<?php
require_once __DIR__ . '/config/db.php';
$db = getDB();

$sql = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS sensor_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    temperature DECIMAL(5,2),
    humidity DECIMAL(5,2),
    gas_level DECIMAL(8,2),
    flame_detected TINYINT(1) DEFAULT 0,
    recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS actuator_state (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pump TINYINT(1) DEFAULT 0,
    buzzer TINYINT(1) DEFAULT 0,
    fan TINYINT(1) DEFAULT 0,
    emergency TINYINT(1) DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS incidents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    incident_type VARCHAR(50),
    temperature DECIMAL(5,2),
    humidity DECIMAL(5,2),
    gas_level DECIMAL(8,2),
    flame_detected TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
";

$statements = array_filter(array_map('trim', explode(';', $sql)));

foreach ($statements as $statement) {
    if ($db->query($statement)) {
        echo "✅ OK: " . substr($statement, 0, 50) . "...<br>";
    } else {
        echo "❌ Error: " . $db->error . "<br>";
    }
}

echo "<br><strong>Done! Now DELETE setup.php from your project!</strong>";
?>
