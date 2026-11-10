
<?php

class Acteur
{
    private $db;

    public function __construct($verbinding)
    {
        $this->db = $verbinding;
    }

    public function ophalen()
    {
        $sql = "SELECT * FROM acteurs ORDER BY achternaam ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function toevoegen($voornaam, $achternaam)
    {
        $sql = "INSERT INTO acteurs
                (voornaam, achternaam)
                VALUES (:voornaam, :achternaam)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':voornaam' => $voornaam,
            ':achternaam' => $achternaam
        ]);
    }

    public function verwijderen($id)
    {
        $sql = "DELETE FROM acteurs WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
} 
