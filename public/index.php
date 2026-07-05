<?php

// Point d'entree unique de l'application (front controller).
// La page a afficher est choisie via le parametre GET "page".

$pagesAutorisees = ['accueil', 'patients', 'praticiens', 'rendezvous'];
$page = $_GET['page'] ?? 'accueil';

if (!in_array($page, $pagesAutorisees, true)) {
    $page = 'accueil';
}

$cheminVue = __DIR__ . '/../views/' . $page . '.php';

$liensNav = [
    'accueil' => ['icone' => 'tableau-de-bord', 'label' => 'Tableau de bord'],
    'patients' => ['icone' => 'patients', 'label' => 'Patients'],
    'praticiens' => ['icone' => 'praticiens', 'label' => 'Praticiens'],
    'rendezvous' => ['icone' => 'rendezvous', 'label' => 'Rendez-vous'],
];
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
    <?php require __DIR__ . '/../views/_icones.php'; ?>

    <div class="app">
        <aside class="barre-laterale">
            <div class="marque">
                <span class="marque-pastille">CM</span>
                <div class="marque-texte">
                    <strong>Cabinet medical</strong>
                    <span>Gestion des rendez-vous</span>
                </div>
            </div>
            <nav>
                <?php foreach ($liensNav as $cle => $lien): ?>
                    <a href="?page=<?= $cle ?>" class="<?= $page === $cle ? 'actif' : '' ?>">
                        <svg class="icone"><use href="#icone-<?= $lien['icone'] ?>"></use></svg>
                        <?= $lien['label'] ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        </aside>

        <div class="contenu">
            <main>
                <?php require $cheminVue; ?>
            </main>
        </div>
    </div>
</body>
</html>
