<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/Patient.php';

/**
 * Classe gestionnaire (Manager) pour l'entite Patient.
 * Contient toutes les operations CRUD, via des requetes preparees PDO.
 */
class PatientManager
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnexion();
    }

    // Ajoute un nouveau patient et renvoie son id genere
    public function ajouter(Patient $patient): int
    {
        $sql = 'INSERT INTO patient (nom, telephone) VALUES (:nom, :telephone)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'nom' => $patient->getNom(),
            'telephone' => $patient->getTelephone(),
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    // Renvoie la liste de tous les patients
    public function lister(): array
    {
        $sql = 'SELECT * FROM patient ORDER BY nom';
        $stmt = $this->pdo->query($sql);

        $patients = [];
        foreach ($stmt->fetchAll() as $ligne) {
            $patients[] = $this->hydrater($ligne);
        }

        return $patients;
    }

    // Recherche un patient par son id, renvoie null si non trouve
    public function trouverParId(int $id): ?Patient
    {
        $sql = 'SELECT * FROM patient WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        return $ligne ? $this->hydrater($ligne) : null;
    }

    // Recherche des patients par nom (fonctionnalite "recherche" demandee dans la consigne)
    public function rechercher(string $motCle): array
    {
        $sql = 'SELECT * FROM patient WHERE nom LIKE :motCle ORDER BY nom';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['motCle' => '%' . $motCle . '%']);

        $patients = [];
        foreach ($stmt->fetchAll() as $ligne) {
            $patients[] = $this->hydrater($ligne);
        }

        return $patients;
    }

    // Met a jour un patient existant
    public function modifier(Patient $patient): bool
    {
        $sql = 'UPDATE patient SET nom = :nom, telephone = :telephone WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nom' => $patient->getNom(),
            'telephone' => $patient->getTelephone(),
            'id' => $patient->getId(),
        ]);
    }

    // Supprime un patient par son id
    public function supprimer(int $id): bool
    {
        $sql = 'DELETE FROM patient WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    // Transforme une ligne de resultat SQL (tableau associatif) en objet Patient
    private function hydrater(array $ligne): Patient
    {
        return new Patient($ligne['nom'], $ligne['telephone'], (int) $ligne['id']);
    }
}
