<?php
session_start(); require_once "config.php"; require_once "User.php"; $user = new User($pdo);
if (!$user->IsLoggedIn()) { header("Location: index.php"); exit; }
?><!DOCTYPE html><html lang="nl"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Dashboard</title><link rel="stylesheet" href="style.css"></head><body><div class="container"><div class="card"><h1>Welkom!</h1><p>Je bent succesvol ingelogd.</p><div class="profile"><p><strong>Gebruikersnaam:</strong> <?=htmlspecialchars($_SESSION["username"])?></p><p><strong>E-mail:</strong> <?=htmlspecialchars($_SESSION["email"])?></p><p><strong>Rol:</strong> <?=htmlspecialchars($_SESSION["role"])?></p></div><a class="button" href="logout.php">Uitloggen</a></div></div></body></html>
