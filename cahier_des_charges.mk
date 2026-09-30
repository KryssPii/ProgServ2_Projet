# Cahier des charges initial — Plateforme de concerts

## 1. Présentation du projet

### 1.1 Nom provisoire

**ConcertHub** — plateforme web de publication et de découverte de concerts.

### 1.2 Contexte

Le projet consiste à réaliser une application web complète en PHP permettant aux artistes de publier leurs propres concerts. Les visiteurs peuvent consulter les événements publiés, tandis que les utilisateurs inscrits peuvent créer un compte, se connecter, ajouter des concerts à leurs favoris et publier des commentaires.

Lorsqu’un artiste soumet un nouvel événement, l’administrateur du site reçoit automatiquement un e-mail de notification. Durant le développement, les e-mails seront interceptés et consultables avec **Mailpit**. En production, le système devra pouvoir être configuré avec un serveur SMTP réel.

L’application comportera une interface utilisateur, une logique métier organisée selon les principes de la programmation orientée objet (POO), ainsi qu’une persistance des données dans une base MariaDB. Elle sera déployée sur Internet et suivra les bonnes pratiques de développement, de sécurité, de gestion de versions et de documentation.

### 1.3 Objectif général

Mettre à disposition une plateforme simple, sécurisée et multilingue qui centralise les concerts proposés par des artistes, facilite leur découverte par le public et permet l’interaction entre les membres.

## 2. Utilisateurs et rôles

| Rôle | Description | Droits principaux |
|---|---|---|
| Visiteur | Personne non connectée | Consulter les pages publiques, la liste des concerts et le détail d’un événement |
| Utilisateur | Membre inscrit et connecté | Gérer son profil, ajouter/retirer des favoris, commenter les événements, se déconnecter |
| Artiste | Utilisateur autorisé à publier des concerts | Tous les droits d’un utilisateur, plus création, modification et suppression de ses propres concerts |
| Administrateur | Responsable de la plateforme | Gérer les utilisateurs, les événements et les commentaires ; modérer ou supprimer les contenus ; recevoir les notifications de création d’événements |

> Un compte peut être créé avec le rôle « utilisateur ». Le rôle « artiste » peut être attribué lors de l’inscription ou par un administrateur. Le rôle administrateur est créé de manière sécurisée en base de données ou via une procédure d’initialisation.

## 3. Fonctionnalités attendues

### 3.1 Pages publiques

La plateforme doit proposer au minimum les pages publiques suivantes :

1. **Accueil** : présente l’objectif de la plateforme, met en avant des concerts récents ou à venir et propose des accès rapides à l’inscription, à la connexion et à la liste des événements.
2. **Liste des concerts** : affiche les événements publiés sous forme de cartes ou de liste, avec les informations principales (titre, artiste, date, lieu, image éventuelle).
3. **Détail d’un concert** : affiche toutes les informations d’un événement, les commentaires associés et, pour un utilisateur connecté, l’action permettant d’ajouter ou retirer l’événement des favoris.
4. **Inscription** : permet de créer un compte utilisateur ou artiste.
5. **Connexion** : permet à un membre existant de s’authentifier.

### 3.2 Inscription et authentification

- Un visiteur peut créer un compte avec un nom/pseudonyme, une adresse e-mail, un mot de passe et le type de compte souhaité (utilisateur ou artiste).
- L’adresse e-mail doit être unique.
- Le mot de passe ne doit jamais être stocké en clair : il sera haché avec `password_hash()` et vérifié avec `password_verify()`.
- Un utilisateur connecté conserve sa session lorsqu’il navigue entre les pages privées.
- L’utilisateur peut se déconnecter à tout moment.
- L’utilisateur connecté peut modifier les informations de son profil, notamment son nom/pseudonyme et son adresse e-mail.

### 3.3 Gestion des concerts par les artistes

Un artiste connecté doit pouvoir :

- Créer un événement via un formulaire PHP.
- Consulter la liste de ses propres événements.
- Modifier un événement qu’il a créé.
- Supprimer un événement qu’il a créé, après confirmation.

Le formulaire de création/modification d’un concert contient au minimum :

| Champ | Type | Règles de validation |
|---|---|---|
| Titre du concert | Texte | Obligatoire, entre 3 et 150 caractères |
| Description | Zone de texte | Obligatoire, longueur maximale définie par l’application |
| Date et heure | Date/heure | Obligatoire ; la date doit être valide |
| Lieu | Texte | Obligatoire |
| Ville | Texte | Obligatoire |
| Adresse | Texte | Facultatif |
| Image/affiche | URL ou fichier selon l’implémentation | Facultatif ; type et taille contrôlés si téléversement |
| Lien de réservation | URL | Facultatif ; format URL valide |

Après validation du formulaire et enregistrement en base de données :

- Le concert est ajouté à la liste publique.
- Un e-mail de notification est envoyé à l’administrateur.
- En environnement de développement, l’e-mail est visible dans Mailpit.
- L’e-mail contient au minimum le titre du concert, l’artiste concerné, la date, le lieu et un lien vers la page d’administration ou le détail du concert.

### 3.4 Favoris

Un utilisateur connecté peut ajouter un concert à ses favoris depuis la page de détail ou la liste des concerts.

- Un même utilisateur ne peut ajouter qu’une seule fois le même concert aux favoris.
- Il peut retirer un concert de ses favoris.
- Une page privée « Mes favoris » affiche les concerts enregistrés par l’utilisateur connecté.

### 3.5 Commentaires

Un utilisateur connecté peut écrire un commentaire sur la page de détail d’un concert.

- Un commentaire contient un message et une date de publication.
- Le message est obligatoire et sa longueur est limitée.
- L’auteur peut modifier ou supprimer son propre commentaire selon le choix d’implémentation.
- L’administrateur peut modérer ou supprimer tout commentaire inapproprié.
- Les contenus affichés doivent être échappés afin de prévenir les attaques XSS.

### 3.6 Administration

L’administrateur dispose d’un espace privé lui permettant au minimum de :

- Consulter les utilisateurs inscrits.
- Consulter l’ensemble des concerts.
- Modifier ou supprimer un concert si nécessaire.
- Consulter, modérer ou supprimer les commentaires.
- Identifier les artistes et les comptes administrateurs.
- Consulter les données principales nécessaires au bon fonctionnement de la plateforme.

## 4. Exigences techniques

### 4.1 Technologies

| Élément | Exigence |
|---|---|
| Langage serveur | PHP 8.x ou version compatible avec l’hébergement |
| Base de données | MariaDB dédiée |
| Accès base de données | PDO avec requêtes préparées |
| Interface | HTML5, CSS3, JavaScript optionnel ou complémentaire |
| E-mails en développement | Mailpit via SMTP |
| Gestion des dépendances | Composer si des bibliothèques externes sont utilisées |
| Serveur web | Apache ou Nginx selon l’hébergement |
| Déploiement | Hébergement Internet, par exemple Infomaniak |
| Gestion de versions | Git et GitHub avec branches, issues et pull requests |

### 4.2 Architecture applicative

Le projet doit respecter une organisation claire et la programmation orientée objet.

L’architecture recommandée est de type MVC ou une architecture équivalente séparant :

- **Présentation** : vues HTML/PHP, feuilles de style et composants d’interface.
- **Contrôleurs** : traitement des requêtes, validation et redirections.
- **Modèles / entités** : classes telles que `User`, `Artist`, `Event`, `Comment`, `Favorite`.
- **Services** : authentification, gestion des e-mails, validation, autorisations.
- **Accès aux données** : repositories ou classes dédiées utilisant PDO.
- **Configuration** : paramètres de base de données et SMTP placés dans un fichier non versionné (par exemple `.env`) ; un fichier `.env.example` doit être fourni.

Un mécanisme d’autoloading des classes doit être mis en place, idéalement via Composer et la norme PSR-4.

### 4.3 Arborescence indicative

```text
project/
├── public/                 # Point d’entrée public et ressources accessibles
│   ├── index.php
│   └── assets/
├── src/
│   ├── Controller/
│   ├── Entity/
│   ├── Repository/
│   ├── Service/
│   └── Security/
├── templates/              # Vues et composants réutilisables
├── config/                 # Configuration non sensible ou exemples
├── migrations/             # Scripts SQL de création/évolution de la base
├── tests/                  # Tests éventuels
├── docs/                   # MCD, MLD, MPD et documents du projet
├── .env.example
├── composer.json
└── README.md
```

## 5. Modèle de données

### 5.1 Entités principales

La base comporte au minimum les entités suivantes :

| Entité | Description |
|---|---|
| `users` | Comptes de la plateforme : utilisateurs, artistes et administrateurs |
| `events` | Concerts créés par les artistes |
| `favorites` | Association entre un utilisateur et un concert favori |
| `comments` | Commentaires publiés sur les concerts |

### 5.2 Proposition de schéma logique

#### Table `users`

| Champ | Type indicatif | Contraintes |
|---|---|---|
| id | INT | Clé primaire, auto-incrémentée |
| username | VARCHAR(100) | Obligatoire |
| email | VARCHAR(255) | Obligatoire, unique |
| password_hash | VARCHAR(255) | Obligatoire |
| role | ENUM ou VARCHAR | `user`, `artist` ou `admin` |
| created_at | DATETIME | Obligatoire |
| updated_at | DATETIME | Facultatif ou obligatoire selon l’implémentation |

#### Table `events`

| Champ | Type indicatif | Contraintes |
|---|---|---|
| id | INT | Clé primaire, auto-incrémentée |
| artist_id | INT | Clé étrangère vers `users.id` |
| title | VARCHAR(150) | Obligatoire |
| description | TEXT | Obligatoire |
| event_date | DATETIME | Obligatoire |
| venue | VARCHAR(150) | Obligatoire |
| city | VARCHAR(100) | Obligatoire |
| address | VARCHAR(255) | Facultatif |
| image_path | VARCHAR(255) | Facultatif |
| ticket_url | VARCHAR(255) | Facultatif |
| created_at | DATETIME | Obligatoire |
| updated_at | DATETIME | Facultatif ou obligatoire selon l’implémentation |

#### Table `favorites`

| Champ | Type indicatif | Contraintes |
|---|---|---|
| user_id | INT | Clé étrangère vers `users.id` |
| event_id | INT | Clé étrangère vers `events.id` |
| created_at | DATETIME | Obligatoire |

La clé primaire peut être composée de `(user_id, event_id)` afin d’empêcher les doublons de favoris.

#### Table `comments`

| Champ | Type indicatif | Contraintes |
|---|---|---|
| id | INT | Clé primaire, auto-incrémentée |
| user_id | INT | Clé étrangère vers `users.id` |
| event_id | INT | Clé étrangère vers `events.id` |
| content | TEXT | Obligatoire |
| created_at | DATETIME | Obligatoire |
| updated_at | DATETIME | Facultatif |

### 5.3 Relations

- Un **artiste** (utilisateur dont le rôle est `artist`) peut créer plusieurs concerts : `users 1 — N events`.
- Un **utilisateur** peut ajouter plusieurs concerts aux favoris et un concert peut être favori de plusieurs utilisateurs : `users N — N events` via `favorites`.
- Un **utilisateur** peut écrire plusieurs commentaires : `users 1 — N comments`.
- Un **concert** peut recevoir plusieurs commentaires : `events 1 — N comments`.

## 6. Sécurité

L’application doit être protégée contre les attaques web courantes.

- Utiliser PDO et des requêtes préparées pour toutes les requêtes SQL afin de prévenir les injections SQL.
- Valider les données côté serveur pour tous les formulaires.
- Échapper les données affichées dans le HTML avec une fonction adaptée, par exemple `htmlspecialchars()`, afin de prévenir les attaques XSS.
- Utiliser des jetons CSRF pour les formulaires modifiant des données : inscription, connexion si retenu, création/modification/suppression de concert, favoris, commentaires et administration.
- Hacher les mots de passe avec `password_hash()` ; ne jamais les stocker, afficher ou envoyer en clair.
- Régénérer l’identifiant de session après une connexion réussie.
- Configurer les cookies de session de façon sécurisée (`HttpOnly`, `Secure` en HTTPS, `SameSite`).
- Vérifier les autorisations sur chaque page privée : un utilisateur non connecté ne peut pas accéder aux espaces protégés ; un artiste ne peut modifier que ses événements ; seul l’administrateur accède à l’administration.
- Protéger les fichiers de configuration contenant les secrets et ne jamais les versionner dans Git.
- Si le téléversement d’images est implémenté, contrôler le type MIME, l’extension, la taille, le nom de fichier et le répertoire de stockage.
- Utiliser HTTPS sur la version déployée.

## 7. Internationalisation (i18n)

La plateforme doit être disponible dans au moins deux langues :

- Français (langue par défaut).
- Anglais.

Les textes de l’interface ne doivent pas être codés en dur dans les pages. Ils doivent être centralisés dans des fichiers de traduction ou un mécanisme équivalent.

L’utilisateur peut modifier la langue via un sélecteur visible. La langue choisie est conservée en session, en cookie ou dans son profil selon l’implémentation.

## 8. Interface et expérience utilisateur

L’interface doit être responsive et utilisable sur ordinateur, tablette et mobile.

Principes attendus :

- Navigation claire avec un en-tête et des liens adaptés à l’état de connexion.
- Formulaires lisibles, avec labels explicites et messages d’erreur précis.
- Retour visuel après les actions importantes : compte créé, connexion réussie, concert publié, favori ajouté, commentaire publié, etc.
- Pages accessibles avec une hiérarchie de titres cohérente, des contrastes suffisants et des champs associés à leurs labels.
- Mise en page cohérente pour les cartes de concerts, les boutons et les messages d’information.

## 9. Pages privées minimales

Afin de satisfaire l’exigence d’au moins cinq pages accessibles après connexion, les pages privées suivantes sont prévues :

1. Tableau de bord utilisateur.
2. Mon profil.
3. Mes favoris.
4. Créer un concert (artiste).
5. Mes concerts (artiste).
6. Modifier un concert (artiste).
7. Administration des utilisateurs (administrateur).
8. Administration des concerts et commentaires (administrateur).

L’accès à certaines de ces pages dépend du rôle du compte connecté.

## 10. E-mails et Mailpit

### 10.1 Cas d’usage principal

À chaque création réussie d’un événement, l’application envoie un e-mail à l’adresse configurée de l’administrateur.

### 10.2 Contenu minimal de l’e-mail

- Objet : `Nouveau concert créé : [titre du concert]`.
- Nom ou pseudonyme de l’artiste.
- Titre du concert.
- Date et heure.
- Lieu et ville.
- Lien vers le détail de l’événement ou l’espace d’administration.

### 10.3 Configuration

Les paramètres SMTP doivent être configurables via des variables d’environnement, par exemple :

```env
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=no-reply@concerthub.local
MAIL_FROM_NAME=ConcertHub
ADMIN_EMAIL=admin@concerthub.local
```

Mailpit est utilisé en développement afin de vérifier les e-mails sans les envoyer vers une adresse réelle. La configuration de production utilisera les paramètres SMTP fournis par l’hébergeur ou un service d’e-mail transactionnel.

## 11. Déploiement

L’application doit être déployée et accessible publiquement sur Internet.

Le déploiement doit prévoir :

- Un hébergement compatible PHP et MySQL/MariaDB, par exemple Infomaniak.
- Une base de données dédiée.
- Un fichier de configuration de production distinct du développement.
- La création des tables à l’aide de scripts SQL ou de migrations versionnées.
- La configuration du répertoire public comme racine web lorsque l’hébergement le permet.
- L’activation de HTTPS.
- La configuration d’une adresse e-mail d’administration et d’un SMTP de production.
- Une procédure documentée de mise à jour de l’application.

L’URL de production devra être ajoutée au README et fournie dans le rendu final.

## 12. Gestion de projet avec Git/GitHub

Le développement suit un workflow collaboratif professionnel :

- Dépôt GitHub privé ou public selon les consignes du cours.
- Une issue GitHub par fonctionnalité, correction ou amélioration importante.
- Une branche dédiée par issue ou fonctionnalité, par exemple `feature/event-creation` ou `fix/comment-validation`.
- Des commits clairs, courts et descriptifs.
- Une pull request pour intégrer une branche dans la branche principale.
- Relecture éventuelle des pull requests, résolution des conflits et fusion documentée.
- Le fichier `.env` est exclu via `.gitignore` ; seul `.env.example` est versionné.

## 13. Livrables

Les livrables attendus sont :

- Le dépôt Git/GitHub contenant le code source et l’historique de développement.
- Les pull requests liées aux fonctionnalités développées.
- Un `README.md` structuré et agréable à lire.
- Les diagrammes de base de données : MCD, MLD et MPD, au format PNG, JPEG, SVG ou équivalent.
- Les scripts SQL ou migrations permettant d’installer la base de données.
- Le fichier `.env.example` sans données sensibles.
- Les instructions d’installation locale, de configuration de Mailpit et de déploiement.
- L’URL publique de l’application déployée.
- Le cahier des charges initial présent dans le dépôt.

## 14. Critères d’acceptation

Le projet est considéré comme fonctionnel lorsque les scénarios suivants réussissent :

1. Un visiteur consulte la page d’accueil, la liste des concerts et le détail d’un concert sans être connecté.
2. Un visiteur crée un compte et peut se connecter avec ses identifiants.
3. Un utilisateur connecté peut modifier son profil et se déconnecter.
4. Un artiste connecté crée un concert au moyen du formulaire PHP.
5. Le concert créé est enregistré dans MySQL/MariaDB et apparaît dans la liste publique.
6. La création du concert déclenche un e-mail visible dans Mailpit en environnement de développement.
7. Un utilisateur connecté ajoute un concert aux favoris, le retrouve dans « Mes favoris », puis peut le retirer.
8. Un utilisateur connecté publie un commentaire sur un concert.
9. Un administrateur peut consulter et gérer les utilisateurs, concerts et commentaires.
10. Les accès privés sont refusés aux visiteurs non connectés et les droits sont contrôlés selon le rôle.
11. Les tentatives d’injection SQL et les contenus HTML/JavaScript dans les champs utilisateurs ne compromettent pas l’application.
12. L’interface est disponible au minimum en français et en anglais.
13. L’application est accessible via une URL publique en HTTPS et fonctionne avec la base de données de production.

## 15. Évolutions possibles

Les fonctionnalités suivantes ne sont pas obligatoires pour une première version, mais peuvent être ajoutées si le temps le permet :

- Recherche par artiste, ville ou titre de concert.
- Filtres par date, ville ou genre musical.
- Carte géographique des lieux de concert.
- Upload d’affiches avec recadrage ou optimisation d’image.
- Validation manuelle des concerts par l’administrateur avant publication.
- Notifications e-mail aux utilisateurs lorsqu’un favori est proche.
- Système de signalement des commentaires.
- Pagination des concerts et des commentaires.
- API REST pour une application mobile future.

## 16. Hors périmètre initial

Les éléments suivants ne font pas partie de la version minimale sauf décision ultérieure :

- Paiement ou vente de billets intégrée.
- Messagerie privée entre membres.
- Gestion complexe de plusieurs scènes ou tournées.
- Connexion via Google, Apple ou réseaux sociaux.
- Application mobile native.

---

## Résumé du périmètre MVP

La première version livrable doit permettre :

- de consulter les concerts publiquement ;
- de créer et gérer des comptes ;
- de différencier au moins les rôles utilisateur, artiste et administrateur ;
- à un artiste de créer et gérer ses concerts ;
- d’envoyer un e-mail à l’administrateur via Mailpit lors de la création d’un concert ;
- à un utilisateur de gérer ses favoris et de commenter ;
- à l’administrateur de modérer les contenus ;
- de stocker les données dans MySQL/MariaDB ;
- de respecter la POO, la sécurité, l’i18n, Git/GitHub, la documentation et le déploiement Internet.
