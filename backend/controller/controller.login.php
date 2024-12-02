<?php

require_once '../model/Database.php';
require_once '../model/LoginUser.php';
require_once '../model/User.php';

// gestione delle politiche CORS
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

session_set_cookie_params([
    'lifetime' => 0,              
    'path' => '/',
    'secure' => false,     
    'httponly' => true,
    'samesite' => 'Lax',  
]);

session_start();

// Se è una richiesta OPTIONS (preflight), invia una risposta di successo
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ricezione dei dati JSON inviati dal frontend
    $data = json_decode(file_get_contents("php://input"));

    // Controllo dati
    if (isset($data->email) && isset($data->password)) {

        //connessione al database
        $database = new Database();
        $pdo = $database->getConnection();

        // Verifica credenziali
        $user = LoginUser::authenticate($pdo, $data->email, $data->password);

        if ($user) {
            //controllo per verificare che l'utente abbia confermato la mail
            if ($user->getIsVerified() === 1) {
                // Login riuscito, salvataggio dati in sessione per passaggio nome a dashboard
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_name'] = $user->getName();
                $_SESSION['user_email'] = $data->email;

                echo json_encode([ 'name' => $user->getName(), 'success' => true, 'message' => 'Login effettuato con successo, stai per essere reindirizzato.' ]);

            } else {
                echo json_encode(['success' => false, 'message' => 'Clicca sul link ricevuto tramite email per proseguire']);
            }

        } else {
            // Login fallito (email o password errati)
            echo json_encode(['success' => false, 'message' => 'Email o password non corretti']);
        }
    } else {
        // Se i dati sono incompleti
        echo json_encode(['success' => false, 'message' => 'Dati incompleti']);
    }
} else {
    // Se la richiesta non è POST
    echo json_encode(['success' => false, 'message' => 'Metodo non permesso']);
}
?>