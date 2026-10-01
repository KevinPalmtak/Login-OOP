```php
<?php

    // Functie: classdefinitie User 

    // Auteur: Studentnaam

    class User{

        // Eigenschappen 

        public string $username = "";
        public string $email = "";
        private string $password = "";

        function setPassword($password){
            $this->password = $password;
        }

        function getPassword(){
            return $this->password;
        }

        public function showUser() {

            echo "<br>Username: $this->username<br>";
            echo "<br>Password: $this->password<br>";
            echo "<br>Email: $this->email<br>";

        }

        public function registerUser(PDO $pdo): array {

            $errors = [];

            // Controleer eerst de invoer
            $errors = $this->validateUser();

            if (!empty($errors)) {
                return $errors;
            }

            // Controleer of username al bestaat
            $stmt = $pdo->prepare(
                "SELECT id FROM user WHERE username = :username"
            );

            $stmt->execute([
                ':username' => $this->username
            ]);

            if ($stmt->fetch()) {

                $errors[] = "Username bestaat al.";

                return $errors;

            } else {

                // username opslaan in tabel login
                $hashedPassword = password_hash(
                    $this->password,
                    PASSWORD_DEFAULT
                );

                $stmt = $pdo->prepare(
                    "INSERT INTO user (username, password)
                     VALUES (:username, :password)"
                );

                $stmt->execute([
                    ':username' => $this->username,
                    ':password' => $hashedPassword
                ]);

                return [];

            }
        }

        function validateUser(){

            $errors=[];

            if (empty($this->username)){
                array_push($errors, "Invalid username");
            }

            if (empty($this->password)){
                array_push($errors, "Invalid password");
            }

            // Test username > 3 tekens
            if (strlen($this->username) < 3 && !empty($this->username)){
                array_push($errors, "Username moet minimaal 3 tekens bevatten");
            }

            return $errors;
        }

        public function loginUser(): bool {

            // Connect database

            // Zoek user in de table user met username = $this->username

            // Doe SELECT * from user WHERE username = $this->username

            // Indien gevonden EN password klopt dan sessie vullen

            // Return true indien gelukt anders false

            return true;
        }

        // Check if the user is already logged in

        public function isLoggedin(): bool {

            // Check if user session has been set

            return false;
        }

        public function getUser(string $username): bool {

            // Connect database

            // Doe SELECT * from user WHERE username = $username

            if (false){

                //Indien gevonden eigenschappen vullen met waarden uit de SELECT

                $this->username = 'Waarde uit de database';

                return true;

            } else {

                return false;

            }   
        }

        public function logout(){

            session_start();

            // remove all session variables

            // destroy the session

        }

    }

?>

