<?php

class Database
{
    private $host = 'localhost';
    private $port = '8889';
    private $dbName = 'brainin';
    private $username = 'root';
    private $password = 'root'; 
    private $pdo;

    // Costruttore: stabilisce la connessione al database
    public function __construct()
    {
        try {
            // Includo la porta nella connessione
            $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->dbName";
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Restituisce l'oggetto PDO
    public function getConnection()
    {
        return $this->pdo;
    }
}
