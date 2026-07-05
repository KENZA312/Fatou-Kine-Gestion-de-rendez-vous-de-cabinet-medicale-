<?php

// Point d'entree unique de l'application (front controller).
// La page a afficher est choisie via le parametre GET "page".

$pagesAutorisees = ['accueil', 'patients', 'praticiens', 'rendezvous'];
$page = $_GET['page'] ?? 'accueil';

if (!in_array($page, $pagesAutorisees, true)) {
    $page = 'accueil';
}

$cheminVue = __DIR__ . '/../views/' . $page . '.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cabinet medical - Gestion des rendez-vous</title>
    <link rel="stylesheet" href="/Gestion-de-rendez-vous/assets/css/style.css">
</head>
<body>
    <header>
        <div class="entete">
            <span class="logo">&#9678;</span>
            <h1>Cabinet medical<span>Gestion des rendez-vous</span></h1>
        </div>
        <nav>
            <a href="?page=accueil" class="<?= $page === 'accueil' ? 'actif' : '' ?>">Accueil</a>
            <a href="?page=patients" class="<?= $page === 'patients' ? 'actif' : '' ?>">Patients</a>
            <a href="?page=praticiens" class="<?= $page === 'praticiens' ? 'actif' : '' ?>">Praticiens</a>
            <a href="?page=rendezvous" class="<?= $page === 'rendezvous' ? 'actif' : '' ?>">Rendez-vous</a>
        </nav>
    </header>

    <main>
        <?php require $cheminVue; ?>
    </main>
</body>
</html>
