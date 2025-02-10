# WG-Putzplan

## Projektstruktur

```
bash
KopierenBearbeiten
/var/www/html/wg-putzplan/
├── wg-putzplan.html          # Haupt-HTML-Datei
├── .htaccess                 # Apache-Konfiguration
├── css/
│   └── wg-putzplan-styles.css  # CSS-Datei mit deinem Design
├── js/
│   └── script.js             # JavaScript-Datei
├── assets/
│   ├── images/               # Bilder, Logos etc.
│   └── fonts/                # Schriften (falls benötigt)
└── backend/
    ├── config.php            # Konfiguration (z. B. DB-Zugangsdaten)
    ├── database.php          # Aufbau der Datenbankverbindung
    ├── register.php          # Registrierungsskript
    ├── login.php             # Login-Skript
    ├── user_management.php   # Skript für die Nutzerverwaltung (Admin)
    └── generate_pdf.php      # PDF-Generierung des Putzplans

```

---

## Codebeispiele

### 1. Datei: **wg-putzplan.html**

```html
html
KopierenBearbeiten
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WG-Putzplan</title>
  <!-- CSS einbinden -->
  <link rel="stylesheet" href="css/wg-putzplan-styles.css">
</head>
<body>
  <header>
    <h1>Willkommen zum WG-Putzplan</h1>
  </header>

  <main class="container">
    <section>
      <p>Organisieren Sie Ihre WG-Aufgaben einfach und effizient.</p>
      <!-- Beispiel-Buttons für Navigation -->
      <a href="backend/login.php" class="btn">Anmelden</a>
      <a href="backend/register.php" class="btn">Registrieren</a>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 WG-Putzplan</p>
  </footer>

  <!-- JavaScript einbinden -->
  <script src="js/script.js"></script>
</body>
</html>

```

---

### 2. Datei: **.htaccess**

```
apacheconf
KopierenBearbeiten
# Setzt wg-putzplan.html als Standardseite
DirectoryIndex wg-putzplan.html

```

---

### 3. Datei: **css/wg-putzplan-styles.css**

```css
css
KopierenBearbeiten
:root {
  --background: #F2EFE7;
  --primary: #9ACBD0;
  --secondary: #48A6A7;
  --accent: #2973B2;
  --text-color: #333;
}

body {
  margin: 0;
  font-family: 'Helvetica', sans-serif;
  background-color: var(--background);
  color: var(--text-color);
}

header {
  background-color: var(--primary);
  color: #fff;
  padding: 1rem;
  text-align: center;
}

.container {
  max-width: 1200px;
  margin: 2rem auto;
  padding: 1rem;
}

.btn {
  display: inline-block;
  background-color: var(--secondary);
  color: #fff;
  padding: 0.5rem 1rem;
  text-decoration: none;
  border-radius: 4px;
  margin: 0.5rem;
}

.btn:hover {
  background-color: var(--accent);
}

footer {
  text-align: center;
  padding: 1rem;
  background-color: var(--primary);
  color: #fff;
}

```

---

### 4. Datei: **js/script.js**

```jsx
javascript
KopierenBearbeiten
// Beispiel: Eine einfache JavaScript-Funktionalität
document.addEventListener('DOMContentLoaded', () => {
  console.log('WG-Putzplan Webanwendung geladen.');
  // Hier kannst du weitere Funktionen hinzufügen,
  // wie z. B. Formvalidierung oder API-Aufrufe.
});

```

---

### 5. Datei: **backend/config.php**

```php
php
KopierenBearbeiten
<?php
// Konfiguration für die Datenbankverbindung
define('DB_HOST', 'localhost');
define('DB_NAME', 'wg_putzplan_db');
define('DB_USER', 'dein_db_benutzer');
define('DB_PASS', 'dein_db_passwort');

// Weitere Konfigurationen, z.B. E-Mail Einstellungen, können hier ergänzt werden.
?>

```

---

### 6. Datei: **backend/database.php**

```php
php
KopierenBearbeiten
<?php
require_once 'config.php';

try {
    // Verbindung über PDO herstellen (empfohlen wegen besserer Sicherheit und Flexibilität)
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}
?>

```

---

### 7. Datei: **backend/register.php**

```php
php
KopierenBearbeiten
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
        echo "Registrierung erfolgreich! Bitte prüfe deine E-Mails zur Bestätigung.";
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

```

---

### 8. Datei: **backend/login.php**

```php
php
KopierenBearbeiten
<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Nutzer anhand der E-Mail abfragen
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        if ($user['is_verified'] == 0) {
            die("Bitte bestätige zuerst deine E-Mail-Adresse.");
        }
        // Anmeldung erfolgreich – starte Session, setze Cookies, etc.
        session_start();
        $_SESSION['user_id'] = $user['id'];
        echo "Login erfolgreich!";
    } else {
        echo "Ungültige E-Mail oder Passwort.";
    }
} else {
    // Einfaches Login-Formular als Beispiel:
    ?>
    <form action="login.php" method="POST">
        E-Mail: <input type="email" name="email"><br>
        Passwort: <input type="password" name="password"><br>
        <input type="submit" value="Login">
    </form>
    <?php
}
?>

```

---

### 9. Datei: **backend/user_management.php**

```php
php
KopierenBearbeiten
<?php
require_once 'database.php';

// Beispiel: Alle Nutzer abrufen (nur für Admins, Sicherheitsprüfung hier nicht implementiert)
$stmt = $pdo->query("SELECT id, first_name, last_name, email, is_verified FROM users");
$users = $stmt->fetchAll();

header('Content-Type: application/json');
echo json_encode($users);
?>

```

---

### 10. Datei: **backend/generate_pdf.php**

*Dieses Beispiel nutzt TCPDF. Stelle sicher, dass TCPDF installiert ist (entweder manuell oder über Composer).*

```php
php
KopierenBearbeiten
<?php
require_once('tcpdf/tcpdf.php');

// Beispiel: Abrufen von Putzplandaten aus der Datenbank
// Hier als Beispiel einfach ein statischer Inhalt
$calendarWeek = date('W');
$filename = "Putzplan_KW" . $calendarWeek . ".pdf";

// Erstelle ein neues PDF-Dokument
$pdf = new TCPDF();
$pdf->AddPage();

// Setze Farben gemäß deiner Farbpalette
// Hintergrundfarbe: #F2EFE7 (RGB: 242,239,231)
// Akzentfarbe: #2973B2 (RGB: 41,115,178)
$pdf->SetFillColor(242, 239, 231);
$pdf->SetTextColor(41, 115, 178);
$pdf->SetFont('helvetica', 'B', 16);

// Füge Titel hinzu
$html = '<h1>WG-Putzplan</h1>';
$html .= '<p>Putzplan für Kalenderwoche ' . $calendarWeek . '</p>';
// Hier kannst du weitere Inhalte (z.B. Tabellen mit Aufgaben) einfügen

$pdf->writeHTML($html, true, false, true, false, '');

// PDF-Ausgabe (Download)
$pdf->Output($filename, 'D');
?>

```

---

## Hinweise zum Deployment

1. **Dateien kopieren:**
    
    Kopiere den gesamten Ordner **wg-putzplan** in das Verzeichnis **/var/www/html/** deines Raspberry Pi.
    
    Beispiel: `/var/www/html/wg-putzplan/`
    
2. **Apache konfigurieren:**
    
    Stelle sicher, dass Apache so konfiguriert ist, dass beim Aufruf des Verzeichnisses die Datei **wg-putzplan.html** geladen wird.
    
    Dies erfolgt über die **.htaccess**-Datei mit der Direktive `DirectoryIndex wg-putzplan.html`.
    
3. **Dateiberechtigungen:**
    
    Sorge dafür, dass Apache Lesezugriff auf alle Dateien und ggf. Ausführungsrechte für die PHP-Skripte besitzt.