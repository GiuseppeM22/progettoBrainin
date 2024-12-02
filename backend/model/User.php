<?php

class User
{
    private $id;
    private $name;
    private $surname;
    private $email;
    private $phone;
    private $password;
    private $createdAt;
    private $otp_token; 
    private $is_verified;

    // Costruttore per la registrazione
    public function __construct($name, $surname, $email, $phone, $password)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
        $this->is_verified = false; 
    }

    // Getter e setter
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getOtpToken()
    {
        return $this->otp_token;
    }

    public function setOtpToken($otp_token)
    {
        $this->otp_token = $otp_token;
    }

    public function getIsVerified()
    {
        return $this->is_verified;
    }

    public function setIsVerified($is_verified)
    {
        $this->is_verified = $is_verified;
    }

    // Metodo per salvare l'utente nel database
    public function saveToDatabase($pdo)
    {
        $sql = "INSERT INTO users (name, surname, email, phone, password, otp_token, is_verified) 
                VALUES (:name, :surname, :email, :phone, :password, :otp_token, :is_verified)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':surname', $this->surname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':otp_token', $this->otp_token); 
        $stmt->bindParam(':is_verified', $this->is_verified, PDO::PARAM_BOOL); // Salva il valore booleano

        return $stmt->execute();
    }
}
