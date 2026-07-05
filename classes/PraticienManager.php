<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/Praticien.php';

/**
 * Classe gestionnaire (Manager) pour l'entite Praticien.
 * Contient toutes les operations CRUD, via des requetes preparees PDO.
 */
class PraticienManager
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnexion();
    }

    // Ajoute un nouveau praticien et renvoie son id genere
    public function ajouter(Praticien $praticien): int
    {
        $sql = 'INSERT INTO praticien (nom) VALUES (:nom)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nom' => $praticien->getNom()]);

        return (int) $this->pdo->lastInsertId();
    }

    // Renvoie la liste de tous les praticiens
    public function lister(): array
    {
        $sql = 'SELECT * FROM praticien ORDER BY nom';
        $stmt = $this->pdo->query($sql);

        $praticiens = [];
        foreach ($stmt->fetchAll() as $ligne) {
            $praticiens[] = $this->hydrater($ligne);
        }

        return $praticiens;
    }

    // Recherche un praticien par son id, renvoie null si non trouve
    public function trouverParId(int $id): ?Praticien
    {
        $sql = 'SELECT * FROM praticien WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        return $ligne ? $this->hydrater($ligne) : null;
    }

    // Met a jour un praticien existant
    public function modifier(Praticien $praticien): bool
    {
        $sql = 'UPDATE praticien SET nom = :nom WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nom' => $praticien->getNom(),
            'id' => $praticien->getId(),
        ]);
    }

    // Supprime un praticien par son id
    public function supprimer(int $id): bool
    {
        $sql = 'DELETE FROM praticien WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    // Transforme une ligne de resultat SQL (tableau associatif) en objet Praticien
    private function hydrater(array $ligne): Praticien
    {
        return new Praticien($ligne['nom'], (int) $ligne['id']);
    }
}
