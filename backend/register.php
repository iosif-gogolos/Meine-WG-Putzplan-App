<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Eingabedaten sicher auslesen
    $firstName = trim($_POST['first_name']);
    $lastName  = trim($_POST['last_name']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $wg_id     = intval($_POST['wg_id']);   // WG-Zuordnung
    $room_id   = intval($_POST['room_id']); // Zimmer-Zuordnung

    // Prüfe, ob alle notwendigen Felder befüllt sind
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        die("Bitte alle Felder ausfüllen.");
    }

    // Passwort sicher hashen
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Optional: Generiere einen Verifizierungstoken (z.B. für E-Mail-Bestätigung)
    $verificationToken = bin2hex(random_bytes(16));

    // Nutzer in der Datenbank einfügen
    $stmt = $pdo->prepare("INSERT INTO users (wg_id, room_id, first_name, last_name, email, password_hash, is_verified, verification_token) VALUES (?, ?, ?, ?, ?, ?, 0, ?)");
    if ($stmt->execute([$wg_id, $room_id, $firstName, $lastName, $email, $passwordHash, $verificationToken])) {
        // Sende E-Mail-Bestätigung (hier nur als Beispiel, implementiere deinen Mailversand)
        // mail($email, "E-Mail bestätigen", "Bitte bestätige deine Registrierung mit folgendem Token: $verificationToken");
        echo "Registrierung erfolgreich! ";
    } else {
        echo "Fehler bei der Registrierung.";
    }
} else {
    // Falls GET-Anfrage: Zeige ein einfaches Registrierungsformular (oder leite auf die HTML-Seite um)
    ?>
    <form action="register.php" method="POST">
        Vorname: <input type="text" name="first_name"><br>
        Nachname: <input type="text" name="last_name"><br>
        E-Mail: <input type="email" name="email"><br>
        Passwort: <input type="password" name="password"><br>
        WG-ID: <input type="number" name="wg_id"><br>
        Zimmer-ID: <input type="number" name="room_id"><br>
        <input type="submit" value="Registrieren">
    </form>
    <?php
}
?>
