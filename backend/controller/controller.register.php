<?php

header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../model/Database.php';
require_once '../model/User.php';
require_once '../sendEmail.php';  

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $data = json_decode(file_get_contents("php://input"));
    // Controlla validita dati
    if (isset($data->name) && isset($data->surname) && isset($data->email) && isset($data->phone) && isset($data->password)) {
        
        // connessione al database
        $database = new Database();
        $pdo = $database->getConnection();

        // Controllo se l'email esiste già nel database
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $data->email);
        $stmt->execute();
        $emailExists = $stmt->fetchColumn();

        if ($emailExists > 0) {
            // Bad request se l'email è già registrata
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['message' => 'La seguente email risulta già registrata, prova ad effettuare il login']);
            exit();
        }

        // se l'email esiste creo un nuovo utente con i dati inviati
        $user = new User($data->name, $data->surname, $data->email, $data->phone, $data->password);

        // Hash della password
        $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));

        // Generazione token OTP unico
        $otp_token = bin2hex(random_bytes(32));
        $user->setOtpToken($otp_token);

        // Salvataggio utente nel database
        if ($user->saveToDatabase($pdo)) {
            // Invio email di conferma
            $confirmationMessage = sendConfirmationEmail($data->email, $data->name, $otp_token);
            
            if (strpos($confirmationMessage, 'successo') !== false) {
                // Risposta positiva al frontend
                echo json_encode(['message' => 'Registrazione avvenuta con successo. Stai per ricevere una mail per confermare la tua registrazione.']);
            } else {
                // Risposta in caso di errore nell'invio dell'email
                echo json_encode(['message' => $confirmationMessage]);
            }
        } else {
            // Risposta di errore
            echo json_encode(['message' => 'Errore durante la registrazione']);
        }

    } else {
        // Risposta di errore se i dati non sono validi
        echo json_encode(['message' => 'Dati incompleti']);
    }
} else {
    // Se la richiesta non è POST
    echo json_encode(['message' => 'Metodo non permesso']);
}
