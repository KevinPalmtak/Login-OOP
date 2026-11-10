
<?php

require_once __DIR__ . '/../config.php';

class Database
{
    private $verbinding;

    public function verbinden()
    {
        try {
            $this->verbinding = new PDO(
                "mysql:host=" . DB_HOST .
                ";dbname=" . DB_NAME .
                ";charset=utf8mb4",
                DB_USER,
                DB_PASS
            );

            $this->verbinding->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $this->verbinding;

        } catch (PDOException $e) {
            die("Databaseverbinding mislukt: " . $e->getMessage());
        }
    }
}
