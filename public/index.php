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
    <title>Cabinet medical - Gestion des rendez-vous</title>
    <link rel="stylesheet" href="/Gestion-de-rendez-vous/assets/css/style.css">
</head>
<body>
    <header>
        <h1>Cabinet medical - Gestion des rendez-vous</h1>
        <nav>
            <a href="?page=accueil">Accueil</a>
            <a href="?page=patients">Patients</a>
            <a href="?page=praticiens">Praticiens</a>
            <a href="?page=rendezvous">Rendez-vous</a>
        </nav>
    </header>

    <main>
        <?php require $cheminVue; ?>
    </main>
</body>
</html>
