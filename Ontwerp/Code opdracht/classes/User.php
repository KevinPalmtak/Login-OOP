<?php

// Functie: classdefinitie User
// Auteur: Studentnaam

class User
{
    // Eigenschappen

    public string $username = "";
    public string $email = "";
    private string $password = "";


    // Wachtwoord instellen
    function setPassword($password)
    {
        $this->password = $password;
    }


    // Wachtwoord ophalen
    function getPassword()
    {
        return $this->password;
    }


    // Gebruiker tonen
    public function showUser()
    {
        echo "<br>Username: $this->username<br>";
        echo "<br>Password: $this->password<br>";
        echo "<br>Email: $this->email<br>";
    }


    // Gebruiker registreren
    public function registerUser(): array
    {
        $errors = [];

        // Controleer eerst de invoer
        $errors = $this->validateUser();

        if (!empty($errors)) {
            return $errors;
        }


        // Maak verbinding met de database
        $pdo = $this->dbConnect();


        // Controleer of username al bestaat
        $stmt = $pdo->prepare(
            "SELECT id FROM `user` WHERE username = :username"
        );

        $stmt->execute([
            ':username' => $this->username
        ]);


        if ($stmt->fetch()) {

            $errors[] = "Username bestaat al.";

            return $errors;

        } else {

            // Wachtwoord veilig hashen
            $hashedPassword = password_hash(
                $this->password,
                PASSWORD_DEFAULT
            );


            // Gebruiker opslaan in de database
            $stmt = $pdo->prepare(
                "INSERT INTO `user` (username, password)
                 VALUES (:username, :password)"
            );

            $stmt->execute([
                ':username' => $this->username,
                ':password' => $hashedPassword
            ]);

            return [];
        }
    }


    // Gebruiker controleren
    function validateUser()
    {
        $errors = [];

        if (empty($this->username)) {
            array_push($errors, "Invalid username");
        }

        if (empty($this->password)) {
            array_push($errors, "Invalid password");
        }


        // Test username > 3 tekens
        if (
            strlen($this->username) < 3
            && !empty($this->username)
        ) {
            array_push(
                $errors,
                "Username moet minimaal 3 tekens bevatten"
            );
        }

        return $errors;
    }


    // Gebruiker inloggen
    public function loginUser(): bool
    {
        // Maak verbinding met de database
        $pdo = $this->dbConnect();


        // Zoek de gebruiker op username
        $stmt = $pdo->prepare(
            "SELECT * FROM `user`
             WHERE username = :username"
        );

        $stmt->execute([
            ':username' => $this->username
        ]);


        // Haal gebruiker op
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        // Controleer username en wachtwoord
        if (password_verify($this->password, $user['password'])) {

            // Start sessie
            if (session_status() === PHP_SESSION_NONE){
            session_start();
            }
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];

            return true;
        }


        return false;

        
    }


    // Check if the user is already logged in
    public function isLoggedin(): bool
    {
        // Start sessie als deze nog niet gestart is
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Controleer of username in de sessie staat
        return isset($_SESSION['username']);
    }


    // Gebruiker ophalen
    public function getUser(string $username): bool
    {
        // Connect database
        $pdo = $this->dbConnect();


        // Zoek gebruiker
        $stmt = $pdo->prepare(
            "SELECT * FROM `user`
             WHERE username = :username"
        );

        $stmt->execute([
            ':username' => $username
        ]);


        // Haal gebruiker op
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user) {

            // Eigenschappen vullen met databasegegevens
            $this->username = $user['username'];

            if (isset($user['email'])) {
                $this->email = $user['email'];
            }

            return true;

        } else {

            return false;
        }
    }


    // Uitloggen
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verwijder alle sessievariabelen
        $_SESSION = [];

        // Vernietig de sessie
        session_destroy();
    }


    // Database connectie
    public function dbConnect()
    {
        require_once __DIR__ . '/../config.php';

        return new PDO($dsn, $username, $password);
    }
    
}
?>
