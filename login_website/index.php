<?php
session_start(); require_once "config.php"; require_once "User.php";
$user = new User($pdo); if ($user->IsLoggedIn()) { header("Location: dashboard.php"); exit; }
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? ""); $password = $_POST["password"] ?? "";
    if ($username === "" || $password === "") $error = "Vul alle velden in.";
    elseif ($user->LoginUser($username, $password)) { header("Location: dashboard.php"); exit; }
    else $error = "Ongeldige gebruikersnaam of wachtwoord.";
}
?>
<!DOCTYPE html><html lang="nl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Login</title><link rel="stylesheet" href="style.css"></head><body><div class="container"><div class="card"><h1>Inloggen</h1><p class="subtitle">Log in op jouw account</p><?php if($error): ?><div class="message error"><?=htmlspecialchars($error)?></div><?php endif; ?><?php if(isset($_GET["registered"])): ?><div class="message success">Account aangemaakt. Je kunt nu inloggen.</div><?php endif; ?><form method="POST"><label>Gebruikersnaam</label><input type="text" name="username" required><label>Wachtwoord</label><input type="password" name="password" required><button type="submit">Inloggen</button></form><p class="link">Nog geen account? <a href="register.php">Registreren</a></p></div></div></body></html>
