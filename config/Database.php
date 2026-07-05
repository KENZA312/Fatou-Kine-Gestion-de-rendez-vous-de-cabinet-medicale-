<?php

/**
 * Classe Database
 * Gere la connexion unique (singleton) a la base de donnees via PDO.
 * Toutes les classes gestionnaires passent par cette classe pour executer
 * leurs requetes preparees.
 */
class Database
{
    private static ?Database $instance = null;

    private string $host = 'localhost';
    private string $dbName = 'gestion_rdv_medical';
    private string $user = 'root';
    private string $password = '';
    private ?PDO $connexion = null;

    // Le constructeur est prive : impossible de faire "new Database()" depuis l'exterieur
    private function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4";

        try {
            $this->connexion = new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die('Erreur de connexion a la base de donnees : ' . $e->getMessage());
        }
    }

    // Point d'acces unique a l'instance de connexion (pattern singleton)
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnexion(): PDO
    {
        return $this->connexion;
    }
}
