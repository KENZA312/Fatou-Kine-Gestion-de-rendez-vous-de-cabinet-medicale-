<?php

require_once __DIR__ . '/../classes/PatientManager.php';

$patientManager = new PatientManager();

// Traitement de l'ajout ou de la modification d'un patient (formulaire envoye en POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $id = $_POST['id'] ?? '';

    if ($nom !== '' && $telephone !== '') {
        if ($id !== '') {
            $patientManager->modifier(new Patient($nom, $telephone, (int) $id));
        } else {
            $patientManager->ajouter(new Patient($nom, $telephone));
        }
    }

    header('Location: index.php?page=patients');
    exit;
}

// Suppression d'un patient
if (isset($_GET['supprimer'])) {
    $patientManager->supprimer((int) $_GET['supprimer']);
    header('Location: index.php?page=patients');
    exit;
}

// Si on clique sur "Modifier", on precharge le patient dans le formulaire
$patientAModifier = isset($_GET['modifier']) ? $patientManager->trouverParId((int) $_GET['modifier']) : null;

// Recherche par nom
$motCle = trim($_GET['recherche'] ?? '');
$patients = $motCle !== '' ? $patientManager->rechercher($motCle) : $patientManager->lister();
?>

<div class="entete-page">
    <h2>Patients</h2>
    <p class="sous-titre"><?= count($patients) ?> patient(s) enregistre(s)</p>
</div>

<section class="carte">
    <form method="get" action="index.php" class="form-recherche">
        <input type="hidden" name="page" value="patients">
        <label>Rechercher un patient par nom
            <input type="text" name="recherche" value="<?= htmlspecialchars($motCle) ?>" placeholder="Ex: Diop">
        </label>
        <button type="submit" class="bouton-ghost">
            <svg class="icone"><use href="#icone-recherche"></use></svg>
            Rechercher
        </button>
    </form>
</section>

<section class="carte">
    <h3><?= $patientAModifier ? 'Modifier le patient' : 'Ajouter un patient' ?></h3>
    <form method="post" action="index.php?page=patients" class="form-grille">
        <?php if ($patientAModifier): ?>
            <input type="hidden" name="id" value="<?= $patientAModifier->getId() ?>">
        <?php endif; ?>
        <label>Nom
            <input type="text" name="nom" value="<?= htmlspecialchars($patientAModifier ? $patientAModifier->getNom() : '') ?>" required>
        </label>
        <label>Telephone
            <input type="text" name="telephone" value="<?= htmlspecialchars($patientAModifier ? $patientAModifier->getTelephone() : '') ?>" required>
        </label>
        <button type="submit">
            <svg class="icone"><use href="#icone-<?= $patientAModifier ? 'modifier' : 'ajouter' ?>"></use></svg>
            <?= $patientAModifier ? 'Modifier le patient' : 'Ajouter le patient' ?>
        </button>
    </form>
</section>

<section class="carte carte-tableau">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Telephone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient): ?>
                <tr>
                    <td><?= htmlspecialchars($patient->getNom()) ?></td>
                    <td><?= htmlspecialchars($patient->getTelephone()) ?></td>
                    <td class="cellule-actions">
                        <a class="bouton bouton-secondaire bouton-petit" href="index.php?page=patients&modifier=<?= $patient->getId() ?>">
                            <svg class="icone"><use href="#icone-modifier"></use></svg>
                            Modifier
                        </a>
                        <a class="bouton bouton-danger bouton-petit" href="index.php?page=patients&supprimer=<?= $patient->getId() ?>" onclick="return confirm('Supprimer ce patient ?')">
                            <svg class="icone"><use href="#icone-supprimer"></use></svg>
                            Supprimer
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($patients)): ?>
                <tr><td colspan="3" class="etat-vide">Aucun patient trouve.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
