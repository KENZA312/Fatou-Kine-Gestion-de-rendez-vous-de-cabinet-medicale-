# Gestion de rendez-vous - Cabinet medical

Application web en PHP oriente objet permettant a un cabinet medical de gerer
ses patients, ses praticiens et la planification des rendez-vous.

## Installation

1. Cloner ce depot dans le dossier `htdocs` de XAMPP :
   ```
   git clone https://github.com/KENZA312/Fatou-Kine-Gestion-de-rendez-vous-de-cabinet-medicale-.git Gestion-de-rendez-vous
   ```
2. Demarrer **Apache** et **MySQL** depuis le panneau de controle XAMPP.
3. Importer la base de donnees :
   - Ouvrir phpMyAdmin (`http://localhost/phpmyadmin`)
   - Onglet **Importer** -> choisir le fichier `sql/script.sql` -> Executer
   - (Le script cree la base `gestion_rdv_medical` et ses 3 tables automatiquement)
4. Verifier les identifiants de connexion dans `config/Database.php` si besoin
   (par defaut : hote `localhost`, utilisateur `root`, mot de passe vide,
   configuration standard de XAMPP).
5. Ouvrir l'application dans le navigateur :
   ```
   http://localhost/Gestion-de-rendez-vous/public/index.php
   ```

## Methodologie

Le projet est organise en couches, chacune avec une responsabilite unique :

- **config/Database.php** : une classe unique gerant la connexion PDO
  (pattern singleton), reutilisee par tous les gestionnaires.
- **classes/** : une classe entite par objet metier (`Patient`, `Praticien`,
  `RendezVous`) avec attributs prives et getters/setters, et une classe
  gestionnaire associee (`PatientManager`, `PraticienManager`,
  `RendezVousManager`) qui execute les requetes SQL preparees (`ajouter`,
  `lister`, `trouverParId`, `modifier`, `supprimer`).
- **views/** : les pages affichees a l'utilisateur (formulaires et listes),
  qui font uniquement appel aux classes gestionnaires (aucune requete SQL
  directe dans les vues).
- **public/index.php** : point d'entree unique de l'application, qui route
  vers la bonne vue selon le parametre `?page=`.

Toutes les requetes SQL utilisent des requetes preparees PDO avec des
parametres nommes, afin d'eviter toute injection SQL.

## Sources

- Documentation officielle PHP : https://www.php.net/manual/fr/
- Documentation PDO : https://www.php.net/manual/fr/book.pdo.php
- Documentation MySQL : https://dev.mysql.com/doc/
