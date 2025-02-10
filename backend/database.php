<?php
require_once 'config.php';

try {
    // Verbindung über PDO herstellen (empfohlen wegen besserer Sicherheit und Flexibilität)
    $dsn = "mysql:host=127.0.0.1;dbname=wg_putzplan_db;charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}
?>
