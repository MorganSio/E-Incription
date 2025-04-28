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
utilisateur à modifier selon vos envies

    sudo -u postgres createuser euser -P
    sudo -u postgres createdb e_inscription -O euser


# Mettre à jour le fichier .env :
utilisateur et mot de passe à modifier selon la création de l'utilisateur et le mot de passe crée précédement

    DATABASE_URL="postgresql://euser:motdepasse@127.0.0.1:5432/e_inscription?serverVersion=15.8&charset=utf8"


## 4. Vérifier la connexion

    php bin/console app:check-database-connection


## 5. Configurer Nginx

# Installation de Nginx

# Étape 1 : Installer Nginx

    sudo apt update
    sudo apt upgrade
    sudo apt install nginx
    sudo systemctl status nginx
    
# Étape 2 : Installer PHP et PHP-FPM

    sudo apt install php-fpm php-mysql php-xml php-mbstring php-curl php-intl php-zip
    sudo systemctl status php8.2-fpm   # ou vérifie ta version de PHP installée (7.4, 8.1, etc)
    (ajoute php-curl, php-intl et php-zip, utiles pour Symfony)

# Étape 3 : Cloner ton projet Symfony depuis GitHub

    cd /var/www
    git clone https://github.com/MorganSio/E-Inscription.git mon_site
    cd mon_site
    composer install

# Étape 4 : Configurer Nginx pour Symfony
# Créer le fichier de config :

    sudo nano /etc/nginx/sites-available/mon_site
# Voici un exemple de configuration :

    server {
        listen 80;
        server_name mon_site.com;
    
        root /var/www/mon_site/public;
        index index.php index.html index.htm;
    
        location / {
            try_files $uri /index.php$is_args$args;
        }
    
        location ~ \.php$ {
            include snippets/fastcgi-php.conf;
            fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;  # Vérifie bien ta version de PHP
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            include fastcgi_params;
        }
    
        location ~ /\.ht {
            deny all;
        }
    }
    
# Ensuite :

    sudo ln -s /etc/nginx/sites-available/mon_site /etc/nginx/sites-enabled/
    sudo nginx -t    # pour tester la config
    sudo systemctl reload nginx
# Étape 5 : Donner les bonnes permissions
    
    sudo chown -R www-data:www-data /var/www/mon_site
    sudo chmod -R 755 /var/www/mon_site
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
