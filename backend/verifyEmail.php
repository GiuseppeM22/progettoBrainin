<?php
require_once './model/Database.php';
require_once './model/User.php';

// Recupero il token
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // connessione al database
    $database = new Database();
    $pdo = $database->getConnection();

    // Verifica token database
    $sql = "SELECT * FROM users WHERE otp_token = :token";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    // Se il token esiste
    if ($stmt->rowCount() > 0) {
        // Recupero i dati dell'utente
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Controllo se l'utente è già verificato
        if ($user['is_verified']) {
            echo "Il tuo account è già stato verificato.";
        } else {
            // Aggiorno lo stato dell'utente a "verificato" = 1
            $updateSql = "UPDATE users SET is_verified = 1 WHERE otp_token = :token";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->bindParam(':token', $token);

            if ($updateStmt->execute()) {
                echo "La tua email è stata verificata con successo! Ora puoi effettuare il login.";
            } else {
                echo "Errore durante la verifica del tuo account.";
            }
        }
    } else {
        echo "Token non valido o scaduto.";
    }
} else {
    echo "Token mancante.";
}
?>
