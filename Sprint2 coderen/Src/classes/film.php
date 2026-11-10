
<?php

class Film
{
    private $db;

    public function __construct($verbinding)
    {
        $this->db = $verbinding;
    }

    public function ophalen()
    {
        $sql = "SELECT * FROM films ORDER BY titel ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function toevoegen($titel, $genre, $releasejaar)
    {
        $sql = "INSERT INTO films
                (titel, genre, releasejaar)
                VALUES (:titel, :genre, :releasejaar)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':titel' => $titel,
            ':genre' => $genre,
            ':releasejaar' => $releasejaar
        ]);
    }

    public function verwijderen($id)
    {
        $sql = "DELETE FROM films WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}
