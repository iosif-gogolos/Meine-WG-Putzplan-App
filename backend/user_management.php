<?php
require_once 'database.php';

// Beispiel: Alle Nutzer abrufen (nur für Admins, Sicherheitsprüfung hier nicht implementiert)
$stmt = $pdo->query("SELECT id, first_name, last_name, email, is_verified FROM users");
$users = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($users);
?>
