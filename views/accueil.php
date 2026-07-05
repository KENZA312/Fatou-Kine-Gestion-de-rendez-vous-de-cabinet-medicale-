<?php

require_once __DIR__ . '/../classes/PatientManager.php';
require_once __DIR__ . '/../classes/PraticienManager.php';
require_once __DIR__ . '/../classes/RendezVousManager.php';

$patientManager = new PatientManager();
$praticienManager = new PraticienManager();
$rdvManager = new RendezVousManager();

$rendezVousTous = $rdvManager->lister();
$nbEnAttente = 0;
foreach ($rendezVousTous as $rdv) {
    if ($rdv->getStatut() === 'en_attente') {
        $nbEnAttente++;
    }
}
?>

<div class="entete-page">
    <h2>Tableau de bord</h2>
    <p class="sous-titre">Vue d'ensemble de l'activite du cabinet</p>
</div>

<div class="grille-stats">
    <div class="stat-carte">
        <svg class="icone icone-stat"><use href="#icone-patients"></use></svg>
        <div>
            <p class="stat-nombre"><?= count($patientManager->lister()) ?></p>
            <p class="stat-libelle">Patients</p>
        </div>
    </div>
    <div class="stat-carte">
        <svg class="icone icone-stat"><use href="#icone-praticiens"></use></svg>
        <div>
            <p class="stat-nombre"><?= count($praticienManager->lister()) ?></p>
            <p class="stat-libelle">Praticiens</p>
        </div>
    </div>
    <div class="stat-carte">
        <svg class="icone icone-stat"><use href="#icone-rendezvous"></use></svg>
        <div>
            <p class="stat-nombre"><?= count($rendezVousTous) ?></p>
            <p class="stat-libelle">Rendez-vous</p>
        </div>
    </div>
    <div class="stat-carte stat-carte-attention">
        <svg class="icone icone-stat"><use href="#icone-confirmer"></use></svg>
        <div>
            <p class="stat-nombre"><?= $nbEnAttente ?></p>
            <p class="stat-libelle">En attente</p>
        </div>
    </div>
</div>

<h3 class="titre-section">Acces rapide</h3>
<div class="grille-accueil">
    <a class="carte carte-lien" href="index.php?page=patients">
        <svg class="icone icone-carte"><use href="#icone-patients"></use></svg>
        <h3>Patients</h3>
        <p>Ajouter, rechercher et gerer les patients du cabinet.</p>
    </a>
    <a class="carte carte-lien" href="index.php?page=praticiens">
        <svg class="icone icone-carte"><use href="#icone-praticiens"></use></svg>
        <h3>Praticiens</h3>
        <p>Gerer la liste des praticiens du cabinet.</p>
    </a>
    <a class="carte carte-lien" href="index.php?page=rendezvous">
        <svg class="icone icone-carte"><use href="#icone-rendezvous"></use></svg>
        <h3>Rendez-vous</h3>
        <p>Planifier, lister par date, confirmer ou annuler un rendez-vous.</p>
    </a>
</div>
