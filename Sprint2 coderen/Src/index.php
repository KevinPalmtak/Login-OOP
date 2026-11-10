<?php

// Classes inladen
require_once 'classes/Database.php';
require_once 'classes/Film.php';
require_once 'classes/Acteur.php';

// Databaseverbinding maken
$database = new Database();
$verbinding = $database->verbinden();

// Objecten aanmaken
$film = new Film($verbinding);
$acteur = new Acteur($verbinding);

// Film toevoegen
if (isset($_POST['film_toevoegen'])) {
    $film->toevoegen(
        $_POST['titel'],
        $_POST['genre'],
        $_POST['releasejaar']
    );
}

// Acteur toevoegen
if (isset($_POST['acteur_toevoegen'])) {
    $acteur->toevoegen(
        $_POST['voornaam'],
        $_POST['achternaam']
    );
}

// Film verwijderen
if (isset($_POST['film_verwijderen'])) {
    $film->verwijderen($_POST['film_id']);
}

// Acteur verwijderen
if (isset($_POST['acteur_verwijderen'])) {
    $acteur->verwijderen($_POST['acteur_id']);
}

// Gegevens ophalen
$films = $film->ophalen();
$acteurs = $acteur->ophalen();

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Film en Acteur Database</title>
</head>
<body>

<h1>Film en Acteur Database</h1>

<h2>Film toevoegen</h2>

<form method="POST">
    <input type="text" name="titel"
           placeholder="Filmtitel" required>

    <input type="text" name="genre"
           placeholder="Genre" required>

    <input type="number" name="releasejaar"
           placeholder="Releasejaar" required>

    <button type="submit" name="film_toevoegen">
        Film toevoegen
    </button>
</form>

<h2>Acteur toevoegen</h2>

<form method="POST">
    <input type="text" name="voornaam"
           placeholder="Voornaam" required>

    <input type="text" name="achternaam"
           placeholder="Achternaam" required>

    <button type="submit" name="acteur_toevoegen">
        Acteur toevoegen
    </button>
</form>

<hr>

<h2>Films</h2>

<?php foreach ($films as $f): ?>

    <p>
        <?= htmlspecialchars($f['titel']) ?>
        (<?= htmlspecialchars($f['genre']) ?>,
        <?= htmlspecialchars((string)$f['releasejaar']) ?>)

        <form method="POST">
            <input type="hidden" name="film_id"
                   value="<?= (int)$f['id'] ?>">

            <button type="submit" name="film_verwijderen">
                Verwijderen
            </button>
        </form>
    </p>

<?php endforeach; ?>

<hr>

<h2>Acteurs</h2>

<?php foreach ($acteurs as $a): ?>

    <p>
        <?= htmlspecialchars($a['voornaam']) ?>
        <?= htmlspecialchars($a['achternaam']) ?>

        <form method="POST">
            <input type="hidden" name="acteur_id"
                   value="<?= (int)$a['id'] ?>">

            <button type="submit" name="acteur_verwijderen">
                Verwijderen
            </button>
        </form>
    </p>

<?php endforeach; ?>

</body>
</html>
