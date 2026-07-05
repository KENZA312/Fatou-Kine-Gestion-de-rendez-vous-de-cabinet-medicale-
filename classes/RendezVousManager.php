<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/RendezVous.php';

/**
 * Classe gestionnaire (Manager) pour l'entite RendezVous.
 * Contient le CRUD ainsi que les fonctionnalites propres a la planification :
 * lister par date, confirmer ou annuler un rendez-vous.
 */
class RendezVousManager
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnexion();
    }

    // Planifie (ajoute) un nouveau rendez-vous et renvoie son id genere
    public function ajouter(RendezVous $rdv): int
    {
        $sql = 'INSERT INTO rendezvous (patient_id, praticien_id, date_rdv, heure_rdv, motif, statut)
                VALUES (:patient_id, :praticien_id, :date_rdv, :heure_rdv, :motif, :statut)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'patient_id' => $rdv->getPatientId(),
            'praticien_id' => $rdv->getPraticienId(),
            'date_rdv' => $rdv->getDateRdv(),
            'heure_rdv' => $rdv->getHeureRdv(),
            'motif' => $rdv->getMotif(),
            'statut' => $rdv->getStatut(),
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    // Renvoie la liste de tous les rendez-vous
    public function lister(): array
    {
        $sql = 'SELECT * FROM rendezvous ORDER BY date_rdv, heure_rdv';
        $stmt = $this->pdo->query($sql);

        $rdvs = [];
        foreach ($stmt->fetchAll() as $ligne) {
            $rdvs[] = $this->hydrater($ligne);
        }

        return $rdvs;
    }

    // Recherche un rendez-vous par son id, renvoie null si non trouve
    public function trouverParId(int $id): ?RendezVous
    {
        $sql = 'SELECT * FROM rendezvous WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        return $ligne ? $this->hydrater($ligne) : null;
    }

    // Liste les rendez-vous d'une date precise (fonctionnalite demandee)
    public function listerParDate(string $date): array
    {
        $sql = 'SELECT * FROM rendezvous WHERE date_rdv = :date ORDER BY heure_rdv';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['date' => $date]);

        $rdvs = [];
        foreach ($stmt->fetchAll() as $ligne) {
            $rdvs[] = $this->hydrater($ligne);
        }

        return $rdvs;
    }

    // Met a jour un rendez-vous existant (date, heure, motif...)
    public function modifier(RendezVous $rdv): bool
    {
        $sql = 'UPDATE rendezvous
                SET patient_id = :patient_id, praticien_id = :praticien_id,
                    date_rdv = :date_rdv, heure_rdv = :heure_rdv, motif = :motif, statut = :statut
                WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'patient_id' => $rdv->getPatientId(),
            'praticien_id' => $rdv->getPraticienId(),
            'date_rdv' => $rdv->getDateRdv(),
            'heure_rdv' => $rdv->getHeureRdv(),
            'motif' => $rdv->getMotif(),
            'statut' => $rdv->getStatut(),
            'id' => $rdv->getId(),
        ]);
    }

    // Confirme un rendez-vous (change son statut en 'confirme')
    public function confirmer(int $id): bool
    {
        return $this->changerStatut($id, 'confirme');
    }

    // Annule un rendez-vous (change son statut en 'annule')
    public function annuler(int $id): bool
    {
        return $this->changerStatut($id, 'annule');
    }

    // Supprime un rendez-vous par son id
    public function supprimer(int $id): bool
    {
        $sql = 'DELETE FROM rendezvous WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    // Change uniquement le statut d'un rendez-vous
    private function changerStatut(int $id, string $statut): bool
    {
        $sql = 'UPDATE rendezvous SET statut = :statut WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'statut' => $statut,
            'id' => $id,
        ]);
    }

    // Transforme une ligne de resultat SQL (tableau associatif) en objet RendezVous
    private function hydrater(array $ligne): RendezVous
    {
        return new RendezVous(
            (int) $ligne['patient_id'],
            (int) $ligne['praticien_id'],
            $ligne['date_rdv'],
            $ligne['heure_rdv'],
            $ligne['motif'],
            $ligne['statut'],
            (int) $ligne['id']
        );
    }
}
