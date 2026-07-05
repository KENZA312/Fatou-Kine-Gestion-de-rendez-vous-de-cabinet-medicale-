<?php

require_once __DIR__ . '/../classes/PraticienManager.php';

$praticienManager = new PraticienManager();

// Traitement de l'ajout ou de la modification d'un praticien (formulaire envoye en POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $id = $_POST['id'] ?? '';

    if ($nom !== '') {
        if ($id !== '') {
            $praticienManager->modifier(new Praticien($nom, (int) $id));
        } else {
            $praticienManager->ajouter(new Praticien($nom));
        }
    }

    header('Location: index.php?page=praticiens');
    exit;
}

// Suppression d'un praticien
if (isset($_GET['supprimer'])) {
    $praticienManager->supprimer((int) $_GET['supprimer']);
    header('Location: index.php?page=praticiens');
    exit;
}

// Si on clique sur "Modifier", on precharge le praticien dans le formulaire
$praticienAModifier = isset($_GET['modifier']) ? $praticienManager->trouverParId((int) $_GET['modifier']) : null;

$praticiens = $praticienManager->lister();
?>

<div class="entete-page">
    <h2>Praticiens</h2>
    <p class="sous-titre"><?= count($praticiens) ?> praticien(s) enregistre(s)</p>
</div>

<section class="carte">
    <h3><?= $praticienAModifier ? 'Modifier le praticien' : 'Ajouter un praticien' ?></h3>
    <form method="post" action="index.php?page=praticiens" class="form-grille">
        <?php if ($praticienAModifier): ?>
            <input type="hidden" name="id" value="<?= $praticienAModifier->getId() ?>">
        <?php endif; ?>
        <label>Nom
            <input type="text" name="nom" value="<?= htmlspecialchars($praticienAModifier ? $praticienAModifier->getNom() : '') ?>" required>
        </label>
        <button type="submit"><?= $praticienAModifier ? 'Modifier le praticien' : 'Ajouter le praticien' ?></button>
    </form>
</section>

<section class="carte carte-tableau">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($praticiens as $praticien): ?>
                <tr>
                    <td><?= htmlspecialchars($praticien->getNom()) ?></td>
                    <td class="cellule-actions">
                        <a class="bouton" href="index.php?page=praticiens&modifier=<?= $praticien->getId() ?>">Modifier</a>
                        <a class="bouton bouton-danger" href="index.php?page=praticiens&supprimer=<?= $praticien->getId() ?>" onclick="return confirm('Supprimer ce praticien ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($praticiens)): ?>
                <tr><td colspan="2" class="etat-vide">Aucun praticien trouve.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
