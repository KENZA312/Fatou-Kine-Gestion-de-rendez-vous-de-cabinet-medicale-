<?php

require_once __DIR__ . '/../classes/RendezVousManager.php';
require_once __DIR__ . '/../classes/PatientManager.php';
require_once __DIR__ . '/../classes/PraticienManager.php';

$rdvManager = new RendezVousManager();
$patientManager = new PatientManager();
$praticienManager = new PraticienManager();

// Planification d'un nouveau rendez-vous (formulaire envoye en POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientId = (int) ($_POST['patient_id'] ?? 0);
    $praticienId = (int) ($_POST['praticien_id'] ?? 0);
    $date = trim($_POST['date_rdv'] ?? '');
    $heure = trim($_POST['heure_rdv'] ?? '');
    $motif = trim($_POST['motif'] ?? '');

    if ($patientId > 0 && $praticienId > 0 && $date !== '' && $heure !== '') {
        $rdvManager->ajouter(new RendezVous($patientId, $praticienId, $date, $heure, $motif !== '' ? $motif : null));
    }

    header('Location: index.php?page=rendezvous');
    exit;
}

// Confirmer un rendez-vous
if (isset($_GET['confirmer'])) {
    $rdvManager->confirmer((int) $_GET['confirmer']);
    header('Location: index.php?page=rendezvous');
    exit;
}

// Annuler un rendez-vous
if (isset($_GET['annuler'])) {
    $rdvManager->annuler((int) $_GET['annuler']);
    header('Location: index.php?page=rendezvous');
    exit;
}

// Filtrer la liste par date (fonctionnalite demandee : lister les RDV par date)
$dateFiltre = trim($_GET['date'] ?? '');
$rendezVousListe = $dateFiltre !== '' ? $rdvManager->listerParDate($dateFiltre) : $rdvManager->lister();

$patients = $patientManager->lister();
$praticiens = $praticienManager->lister();

// Retrouve le nom d'un patient/praticien a partir de son id, pour l'affichage dans le tableau
function nomPatient(array $patients, int $id): string
{
    foreach ($patients as $patient) {
        if ($patient->getId() === $id) {
            return $patient->getNom();
        }
    }
    return 'Inconnu';
}

function nomPraticien(array $praticiens, int $id): string
{
    foreach ($praticiens as $praticien) {
        if ($praticien->getId() === $id) {
            return $praticien->getNom();
        }
    }
    return 'Inconnu';
}
?>

<div class="entete-page">
    <h2>Rendez-vous</h2>
    <p class="sous-titre"><?= count($rendezVousListe) ?> rendez-vous <?= $dateFiltre !== '' ? 'le ' . htmlspecialchars($dateFiltre) : 'au total' ?></p>
</div>

<section class="carte">
    <h3>Planifier un rendez-vous</h3>
    <form method="post" action="index.php?page=rendezvous" class="form-grille">
        <label>Patient
            <select name="patient_id" required>
                <option value="">-- Choisir un patient --</option>
                <?php foreach ($patients as $patient): ?>
                    <option value="<?= $patient->getId() ?>"><?= htmlspecialchars($patient->getNom()) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Praticien
            <select name="praticien_id" required>
                <option value="">-- Choisir un praticien --</option>
                <?php foreach ($praticiens as $praticien): ?>
                    <option value="<?= $praticien->getId() ?>"><?= htmlspecialchars($praticien->getNom()) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Date
            <input type="date" name="date_rdv" required>
        </label>
        <label>Heure
            <input type="time" name="heure_rdv" required>
        </label>
        <label class="label-large">Motif
            <input type="text" name="motif" placeholder="Ex: Controle general">
        </label>
        <button type="submit">
            <svg class="icone"><use href="#icone-ajouter"></use></svg>
            Planifier le rendez-vous
        </button>
    </form>
</section>

<section class="carte">
    <form method="get" action="index.php" class="form-recherche">
        <input type="hidden" name="page" value="rendezvous">
        <label>Filtrer par date
            <input type="date" name="date" value="<?= htmlspecialchars($dateFiltre) ?>">
        </label>
        <button type="submit" class="bouton-ghost">
            <svg class="icone"><use href="#icone-recherche"></use></svg>
            Filtrer
        </button>
        <a class="bouton-lien" href="index.php?page=rendezvous">Tout afficher</a>
    </form>
</section>

<section class="carte carte-tableau">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Praticien</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Motif</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rendezVousListe as $rdv): ?>
                <tr>
                    <td><?= htmlspecialchars(nomPatient($patients, $rdv->getPatientId())) ?></td>
                    <td><?= htmlspecialchars(nomPraticien($praticiens, $rdv->getPraticienId())) ?></td>
                    <td><?= htmlspecialchars($rdv->getDateRdv()) ?></td>
                    <td><?= htmlspecialchars($rdv->getHeureRdv()) ?></td>
                    <td><?= htmlspecialchars($rdv->getMotif() ?? '') ?></td>
                    <td><span class="badge badge-<?= htmlspecialchars($rdv->getStatut()) ?>"><?= htmlspecialchars($rdv->getStatut()) ?></span></td>
                    <td class="cellule-actions">
                        <a class="bouton" href="index.php?page=rendezvous&confirmer=<?= $rdv->getId() ?>">Confirmer</a>
                        <a class="bouton bouton-danger" href="index.php?page=rendezvous&annuler=<?= $rdv->getId() ?>" onclick="return confirm('Annuler ce rendez-vous ?')">Annuler</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($rendezVousListe)): ?>
                <tr><td colspan="7" class="etat-vide">Aucun rendez-vous trouve.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
