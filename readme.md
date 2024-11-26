# E-Inscription

Bienvenue dans mon projet Symfony! Ce projet est construit avec le framework Symfony et utilise Doctrine ORM pour la gestion des bases de données.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les éléments suivants sur votre machine :

- PHP >= 7.4
- Composer
- Un serveur Web (Apache, Nginx, etc.)
- Une base de données (MySQL, PostgreSQL, SQLite, etc.)

## Installation

### 1. Cloner le Dépôt

Clonez le dépôt GitHub sur votre machine locale :

git clone [https://github.com/MorganSio/E-Incription.git](https://github.com/MorganSio/E-Incription.git)
cd your-repository

### 2. Installer les Dépendances
composer install

### 3. Configuration de l'Environnement
Modifiez le fichier .env pour y ajouter vos informations de connexion à la base de données postgresql :

exemple :  DATABASE_URL="postgresql://user:mdp@1.2.3.4:5432/E-Inscription?serverVersion=15.8&charset=utf8"

### 4. Vérifiez la connection a la base de donnée 
php bin/console app:check-database-connection

### 5. Démarrer le Serveur de Développement
symfony server:start