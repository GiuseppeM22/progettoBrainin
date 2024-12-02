<?php

class LoginUser
{
    private $email;
    private $password;
    private $name;
    private $id;
    private $isVerified;
    
    public function __construct($email, $password, $name = null, $id = null, $isVerified = false)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name; 
        $this->id = $id;
        $this->isVerified = $isVerified; 
    }

    // Getter
    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIsVerified()
    {
        return $this->isVerified;
    }

    // Metodo per verificare le credenziali
    public static function authenticate($pdo, $email, $password)
    {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica la password
            if (password_verify($password, $row['password'])) {
                // Restituisce un oggetto LoginUser con nome, email, password e is_verified
                return new self($row['email'], $row['password'], $row['name'], $row['id'], $row['is_verified']);
            }
        }

        return null; 
    }
}
?>
