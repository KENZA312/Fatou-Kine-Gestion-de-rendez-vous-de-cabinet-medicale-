<?php

/**
 * Classe entite Praticien
 * Represente un praticien (medecin) du cabinet. Attributs prives + getters/setters
 * pour respecter le principe d'encapsulation.
 */
class Praticien
{
    private ?int $id;
    private string $nom;

    public function __construct(string $nom, ?int $id = null)
    {
        $this->nom = $nom;
        $this->id = $id;
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    // Setters
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }
}
