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
