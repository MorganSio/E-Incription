## 📋 E-Inscription
# Bienvenue dans E-Inscription, un projet Symfony permettant la gestion des inscriptions via une interface web. Ce projet utilise Symfony comme framework principal et Doctrine ORM pour l’interaction avec une base de données PostgreSQL.

## 🚀 Fonctionnalités principales
# Gestion des utilisateurs

# Interface d’inscription en ligne

# Interaction avec une base de données PostgreSQL

# Architecture MVC avec Symfony

## ✅ Prérequis
# Assurez-vous d’avoir les éléments suivants installés :

    PHP = 8.2
    Composer
    PostgreSQL 15.8
    Un serveur Web (Apache, Nginx, ou le serveur Symfony en local)
    Symfony CLI (recommandé)



## 🛠️ Installation en local
## 1. Cloner le dépôt

    git clone https://github.com/MorganSio/E-Incription.git
    cd E-Incription


## 2. Installer les dépendances

    composer install


## 3. Configurer la base de données
# Modifiez le fichier .env à la racine du projet :

    DATABASE_URL="postgresql://votre_user:votre_motdepasse@localhost:5432/E-Inscription?serverVersion=15.8&charset=utf8"


## 4. Vérifier la connexion à la base de données

    php bin/console app:check-database-connection


## 5. Démarrer le serveur de développement

    symfony server:start


## 🌐 Déploiement sur un serveur distant (Linux - Ubuntu recommandé)
# Voici les étapes pour installer l'application et la base de données sur un serveur distant.


## 1. Installer les dépendances nécessaires

    sudo apt update && sudo apt install -y \
    php php-cli php-mbstring php-xml php-curl php-pgsql php-intl \
    unzip curl git nginx postgresql postgresql-contrib \
    composer


## 2. Cloner le dépôt et configurer le projet

    cd /var/www/
    sudo git clone https://github.com/MorganSio/E-Incription.git
    cd E-Incription
    composer install


## 3. Configurer la base de données PostgreSQL
# Créer un utilisateur et une base :

    sudo -u postgres createuser euser -P
    sudo -u postgres createdb e_inscription -O euser


# Mettre à jour le fichier .env :

    DATABASE_URL="postgresql://euser:motdepasse@127.0.0.1:5432/e_inscription?serverVersion=15.8&charset=utf8"


## 4. Vérifier la connexion

    php bin/console app:check-database-connection


## 5. Configurer Nginx
# Créer un fichier de configuration Nginx :

    sudo nano /etc/nginx/sites-available/e-inscription


# Contenu exemple :


    server {

    listen 80;
    server_name your-domain.com;
    root /var/www/E-Incription/public;
    index index.php index.html;
    location / {
        try_files $uri /index.php$is_args$args;
    }
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    }
    location ~ /\.ht {
        deny all;
    }


# Activer le site et recharger Nginx :

    sudo ln -s /etc/nginx/sites-available/e-inscription /etc/nginx/sites-enabled/
    sudo systemctl reload nginx


## 6. Lancer les migrations et créer le schéma

    php bin/console doctrine:migrations:migrate


## 📦 Autres commandes utiles
# Lancer les tests :

    php bin/phpunit


# Créer un utilisateur administrateur (si applicable) :

    php bin/console app:create-admin
