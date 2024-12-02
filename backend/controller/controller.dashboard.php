<?php
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


// Verifico se l'utente è loggato
if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    // Utente loggato
    echo json_encode(['success' => true, 'name' => $_SESSION['user_name']]);
    exit();
} else {
    // Utente non loggato
    echo json_encode(['success' => false, 'message' => 'Utente non loggato']);
}
?>

