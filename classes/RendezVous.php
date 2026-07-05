<?php

/**
 * Classe entite RendezVous
 * Represente un rendez-vous entre un patient et un praticien.
 * Attributs prives + getters/setters pour respecter l'encapsulation.
 */
class RendezVous
{
    private ?int $id;
    private int $patientId;
    private int $praticienId;
    private string $dateRdv;
    private string $heureRdv;
    private ?string $motif;
    private string $statut;

    public function __construct(
        int $patientId,
        int $praticienId,
        string $dateRdv,
        string $heureRdv,
        ?string $motif = null,
        string $statut = 'en_attente',
        ?int $id = null
    ) {
        $this->patientId = $patientId;
        $this->praticienId = $praticienId;
        $this->dateRdv = $dateRdv;
        $this->heureRdv = $heureRdv;
        $this->motif = $motif;
        $this->statut = $statut;
        $this->id = $id;
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatientId(): int
    {
        return $this->patientId;
    }

    public function getPraticienId(): int
    {
        return $this->praticienId;
    }

    public function getDateRdv(): string
    {
        return $this->dateRdv;
    }

    public function getHeureRdv(): string
    {
        return $this->heureRdv;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setPatientId(int $patientId): void
    {
        $this->patientId = $patientId;
    }

    public function setPraticienId(int $praticienId): void
    {
        $this->praticienId = $praticienId;
    }

    public function setDateRdv(string $dateRdv): void
    {
        $this->dateRdv = $dateRdv;
    }

    public function setHeureRdv(string $heureRdv): void
    {
        $this->heureRdv = $heureRdv;
    }

    public function setMotif(?string $motif): void
    {
        $this->motif = $motif;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }
}
