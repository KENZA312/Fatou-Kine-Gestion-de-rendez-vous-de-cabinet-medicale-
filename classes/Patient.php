<?php

/**
 * Classe entite Patient
 * Represente un patient du cabinet. Attributs prives + getters/setters
 * pour respecter le principe d'encapsulation.
 */
class Patient
{
    private ?int $id;
    private string $nom;
    private string $telephone;

    public function __construct(string $nom, string $telephone, ?int $id = null)
    {
        $this->nom = $nom;
        $this->telephone = $telephone;
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

    public function getTelephone(): string
    {
        return $this->telephone;
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

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }
}
