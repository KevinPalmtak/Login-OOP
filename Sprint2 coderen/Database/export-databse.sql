CREATE DATABASE film_database;

USE film_database;

CREATE TABLE films (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titel VARCHAR(255) NOT NULL,
    genre VARCHAR(100) NOT NULL,
    releasejaar INT NOT NULL
);

CREATE TABLE acteurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    voornaam VARCHAR(100) NOT NULL,
    achternaam VARCHAR(100) NOT NULL
);

CREATE TABLE film_acteur (
    film_id INT NOT NULL,
    acteur_id INT NOT NULL,

    PRIMARY KEY (film_id, acteur_id),

    FOREIGN KEY (film_id)
        REFERENCES films(id)
        ON DELETE CASCADE,

    FOREIGN KEY (acteur_id)
        REFERENCES acteurs(id)
        ON DELETE CASCADE
);