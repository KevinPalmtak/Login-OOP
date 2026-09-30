<?php
session_start(); require_once "config.php"; require_once "User.php";
$user = new User($pdo); $error = ""; if ($user->IsLoggedIn()) { header("Location: dashboard.php"); exit; }
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? ""); $email = trim($_POST["email"] ?? ""); $password = $_POST["password"] ?? "";
    if ($username === "" || $email === "" || $password === "") $error = "Vul alle velden in.";
    elseif (strlen($password) < 6) $error = "Het wachtwoord moet minimaal 6 tekens hebben.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = "Vul een geldig e-mailadres in.";
    elseif ($user->RegisterUser($username, $password, $email)) { header("Location: index.php?registered=1"); exit; }
    else $error = "Gebruikersnaam of e-mail bestaat al.";
}
?>
<!DOCTYPE html><html lang="nl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Registreren</title><link rel="stylesheet" href="style.css"></head><body><div class="container"><div class="card"><h1>Registreren</h1><p class="subtitle">Maak een nieuw account</p><?php if($error): ?><div class="message error"><?=htmlspecialchars($error)?></div><?php endif; ?><form method="POST"><label>Gebruikersnaam</label><input type="text" name="username" required><label>E-mail</label><input type="email" name="email" required><label>Wachtwoord</label><input type="password" name="password" required><button type="submit">Account maken</button></form><p class="link">Heb je al een account? <a href="index.php">Inloggen</a></p></div></div></body></html>
