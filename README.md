# IMDb & co — Documentation technique

## Présentation

IMDb & co est un site web permettant aux utilisateurs de consulter des films, de les rechercher par titre ou réalisateur, de les ajouter à un panier et de les acheter. Développé en PHP avec une base de données MySQL, le site est entièrement responsive.

---

## Installation

### Prérequis

- WAMP (Windows) / XAMPP / LAMP (Linux) installé sur la machine
- PHP 8.0 ou supérieur
- MySQL 5.7 ou supérieur
- Navigateur web moderne

### Étapes

1. Copier le dossier du projet dans le répertoire `www/` de WAMP (ou `htdocs/` de XAMPP)
2. Démarrer WAMP et s'assurer qu'Apache et MySQL sont actifs (icône verte)
3. Ouvrir un terminal et se connecter à MySQL :

mysql -u root -p

4. Créer la base de données :
```sql
CREATE DATABASE utilisateurs;
USE utilisateurs;
```
5. Importer le fichier `database.sql` :
```bash
mysql -u root -p utilisateurs < database.sql
```
6. Ouvrir `configphp.php` et vérifier les paramètres de connexion (voir ci-dessous)
7. Accéder au site : [http://localhost/nom_du_dossier/index.php]

### Paramètres de connexion BDD (`configphp.php`)

```php
$servername = "localhost";
$username   = "root";       // votre username MySQL
$password   = "";           // votre mot de passe MySQL
$dbname     = "utilisateurs";
```

---

## Schéma de la base de données

Base de données : `utilisateurs`

### Table `users`
Stocke les comptes utilisateurs. Le mot de passe est hashé avec `password_hash()`.

| Colonne     | Type         | Description                         |
|-------------|--------------|-------------------------------------|
| id          | INT          | Identifiant unique                  |
| pseudo      | VARCHAR(255) | Nom d'affichage                     |
| nom         | VARCHAR(255) | Nom de famille                      |
| prenom      | VARCHAR(255) | Prénom                              |
| motDePasse  | VARCHAR(255) | Mot de passe hashé (bcrypt)         |
| email       | VARCHAR(255) | Adresse email                       |
| token       | VARCHAR(255) | Token de session (connexion cookie) |

### Table `films`

| Colonne        | Type          | Description                   |
|----------------|---------------|-------------------------------|
| id             | INT           | Identifiant unique            |
| titre          | VARCHAR(255)  | Titre du film                 |
| description    | VARCHAR(255)  | Synopsis                      |
| prix           | DECIMAL(10,2) | Prix d'achat                  |
| image          | VARCHAR(255)  | Nom du fichier image          |
| realisateur_id | INT           | Référence vers `realisateurs` |
| Sortie         | INT           | Année de sortie               |

### Table `realisateurs`

| Colonne | Type         | Description        |
|---------|--------------|--------------------|
| id      | INT          | Identifiant unique |
| name    | VARCHAR(255) | Nom du réalisateur |

### Table `genres`

| Colonne | Type         | Description                    |
|---------|--------------|--------------------------------|
| id      | INT          | Identifiant unique             |
| nom     | VARCHAR(255) | Nom du genre (Drame, Action…)  |

### Table `liaisonGenres` (many-to-many films ↔ genres)

| Colonne  | Type      | Description             |
|----------|-----------|-------------------------|
| id       | INT       | Identifiant unique      |
| movie_id | INT       | Référence vers `films`  |
| genre_id | INT       | Référence vers `genres` |

### Table `acteurs`

| Colonne | Type         | Description        |
|---------|--------------|--------------------|
| id      | INT          | Identifiant unique |
| name    | VARCHAR(255) | Nom de l'acteur    |

### Table `liaisonActeurs` (many-to-many films ↔ acteurs)

| Colonne   | Type   | Description              |
|-----------|--------|--------------------------|
| movie_id  | INT    | Référence vers `films`   |
| acteur_id | INT    | Référence vers `acteurs` |

### Table `achats`
Historique des commandes, accessible depuis la page Profil.

| Colonne    | Type          | Description                  |
|------------|---------------|------------------------------|
| id         | INT           | Identifiant unique           |
| user_id    | INT           | Référence vers `users`       |
| prix_achat | DECIMAL(10,2) | Montant total de la commande |
| date_achat | DATETIME      | Date et heure de l'achat     |

---

## Pages du site

| Fichier                      | Rôle                                            |
|------------------------------|-------------------------------------------------|
| `index.php`                  | Accueil : hero, tendances, nouveautés           |
| `recherche.php`              | Recherche par titre ou réalisateur              |
| `Categorie.php`              | Liste des catégories disponibles                |
| `filmsAction.php`            | Films d'action                                  |
| `filmsDrame.php`             | Films de drame                                  |
| `film_details.php`           | Détail d'un film (acteurs, réalisateur, prix)   |
| `par_realisateur.php`        | Tous les films d'un réalisateur                 |
| `connexion.php`              | Formulaire de connexion                         |
| `traitement_connexion.php`   | Traitement POST connexion                       |
| `inscription.php`            | Formulaire d'inscription                        |
| `traitement_inscription.php` | Traitement POST inscription                     |
| `deconnexion.php`            | Supprime la session et les cookies              |
| `panier.php`                 | Panier utilisateur (ajout, suppression, total)  |
| `valider_paiement.php`       | Enregistre la commande et vide le panier        |
| `profil.php`                 | Profil : historique achats + changement MDP     |
| `traitement_profil.php`      | Traitement POST changement de mot de passe      |
| `configphp.php`              | Connexion PDO à la base de données              |

---

## Sécurité

- **Mots de passe hashés** : stockés avec `password_hash()` (bcrypt), vérifiés avec `password_verify()`
- **Requêtes préparées** : toutes les requêtes SQL utilisent PDO avec paramètres nommés (protection injection SQL)
- **Échappement HTML** : toutes les données affichées passent par `htmlspecialchars()` (protection XSS)
- **Validation des inputs** : vérification des types, formats et longueurs avant toute insertion
- **Authentification par cookie** : token unique généré à la connexion, stocké en base et comparé au cookie
- **Cookies sécurisés** : flags `httponly` et `samesite: Strict` activés
- **Accès protégé** : le panier et le profil vérifient la validité du cookie avant tout affichage

---

## Structure des fichiers

```
/projet/
├── index.php
├── recherche.php
├── Categorie.php
├── filmsAction.php
├── filmsDrame.php
├── film_details.php
├── par_realisateur.php
├── connexion.php
├── traitement_connexion.php
├── inscription.php
├── traitement_inscription.php
├── deconnexion.php
├── panier.php
├── valider_paiement.php
├── profil.php
├── traitement_profil.php
├── configphp.php
├── database.sql
├── README.md
├── CSS/
│   ├── index.css
│   ├── inscription.css
│   ├── recherche.css
│   ├── categorie.css
│   ├── filmsAction.css
│   ├── filmsDrame.css
│   ├── details.css
│   ├── panier.css
│   └── profil.css
└── assets/
    ├── img/      (affiches des films)
    └── logo/     (icônes SVG)
```