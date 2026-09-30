<?php
class User {
    private PDO $pdo;
    public string $Username = "";
    private string $Password = "";
    public string $Email = "";
    public string $Role = "user";

    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function ValidateLogin(string $username, string $password): bool {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(["username" => $username]);
        $user = $stmt->fetch();
        if (!$user || !password_verify($password, $user["password"])) return false;
        $this->Username = $user["username"];
        $this->Password = $user["password"];
        $this->Email = $user["email"];
        $this->Role = $user["role"];
        return true;
    }

    public function RegisterUser(string $username, string $password, string $email, string $role = "user"): bool {
        if ($username === "" || $password === "" || $email === "") return false;
        $check = $this->pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email LIMIT 1");
        $check->execute(["username" => $username, "email" => $email]);
        if ($check->fetch()) return false;
        $this->Username = $username;
        $this->Email = $email;
        $this->Role = $role;
        $this->SetPassword($password);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, :role)");
        return $stmt->execute(["username" => $this->Username, "password" => $this->Password, "email" => $this->Email, "role" => $this->Role]);
    }

    public function LoginUser(string $username, string $password): bool {
        if (!$this->ValidateLogin($username, $password)) return false;
        session_regenerate_id(true);
        $_SESSION["user_id"] = true;
        $_SESSION["username"] = $this->Username;
        $_SESSION["email"] = $this->Email;
        $_SESSION["role"] = $this->Role;
        return true;
    }

    public function IsLoggedIn(): bool { return isset($_SESSION["user_id"]); }
    public function SetPassword(string $password): void { $this->Password = password_hash($password, PASSWORD_DEFAULT); }
    public function GetPassword(): string { return $this->Password; }
}
?>
