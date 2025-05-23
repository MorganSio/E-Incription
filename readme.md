# 📋 E-Inscription

Bienvenue dans E-Inscription, un projet Symfony permettant la gestion des inscriptions via une interface web. Ce projet utilise Symfony comme framework principal et Doctrine ORM pour l'interaction avec une base de données PostgreSQL.

## 🚀 Fonctionnalités principales

- Gestion des utilisateurs
- Interface d'inscription en ligne
- Interaction avec une base de données PostgreSQL
- Architecture MVC avec Symfony

## ✅ Prérequis

Assurez-vous d'avoir les éléments suivants installés :

- PHP 8.2
- Composer
- PostgreSQL 15.8
- Un serveur Web (Apache, Nginx, ou le serveur Symfony en local)
- Symfony CLI (recommandé)
- Avoir installé Libre Office sur le pc avec la version la plus récente

## 🛠️ Installation en local

### 1. Cloner le dépôt

```bash
git clone https://github.com/MorganSio/E-Inscription.git
cd E-Inscription
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configurer la base de données

Modifiez le fichier `.env` à la racine du projet :

```
DATABASE_URL="postgresql://votre_user:votre_motdepasse@localhost:5432/E-Inscription?serverVersion=15.8&charset=utf8"
```

### 4. Vérifier la connexion à la base de données

```bash
php bin/console app:check-database-connection
```

### Extensions PHP requises

Assurez-vous que les extensions PHP suivantes sont activées dans votre fichier php.ini :

```
extension=curl
extension=mbstring
extension=openssl
extension=pdo_pgsql
extension=intl
extension=json
extension=tokenizer
extension=ctype
extension=xml
extension=fileinfo
extension=gd
extension=zip
extension=pgsql
```

### 1. Cloner le dépôt

```bash
git clone https://github.com/MorganSio/E-Inscription.git
cd E-Inscription
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configurer la base de données

Modifiez le fichier `.env` à la racine du projet :

```
DATABASE_URL="postgresql://votre_user:votre_motdepasse@localhost:5432/E-Inscription?serverVersion=15.8&charset=utf8"
```

### 4. Vérifier la connexion à la base de données

```bash
php bin/console app:check-database-connection
```

### 5. Démarrer le serveur de développement

```bash
symfony server:start
```

## 🌐 Déploiement sur un serveur distant (Linux - Ubuntu recommandé)

Voici les étapes pour installer l'application et la base de données sur un serveur distant.

### 1. Installer les dépendances nécessaires

```bash
sudo apt update && sudo apt install -y \
php php-cli php-mbstring php-xml php-curl php-pgsql php-intl \
php-json php-tokenizer php-ctype php-fileinfo php-gd php-zip \
unzip curl git nginx postgresql postgresql-contrib \
composer
```

### 2. Cloner le dépôt et configurer le projet

```bash
cd /var/www/
sudo git clone https://github.com/MorganSio/E-Inscription.git
cd E-Inscription
composer install
```

### 3. Configurer la base de données PostgreSQL

Créer un utilisateur et une base :
> Note : Utilisateur à modifier selon vos besoins

```bash
sudo -u postgres createuser euser -P
sudo -u postgres createdb e_inscription -O euser
```

Mettre à jour le fichier pg_hba
```bash
sudo nano /etc/postgresql/15/main/pg_hba.conf
```

puis ajouter la ligne
> Note : les valleurs e_inscription euser et 127.0.0.1/32 sont a remplacer par la basse de donnée, l'utilisateur l'adresse du réseau ou du client directement
```bash
host e_inscription euser 127.0.0.1/32 password
```

Voici les étapes pour installer l'application et la base de données sur un serveur distant.

### 1. Installer les dépendances nécessaires

```bash
sudo apt update && sudo apt install -y \
php php-cli php-mbstring php-xml php-curl php-pgsql php-intl \
unzip curl git nginx postgresql postgresql-contrib \
composer
```

### 2. Cloner le dépôt et configurer le projet

```bash
cd /var/www/
sudo git clone https://github.com/MorganSio/E-Inscription.git
cd E-Inscription
composer install
```

### 3. Configurer la base de données PostgreSQL

Créer un utilisateur et une base :
> Note : Utilisateur à modifier selon vos besoins

```bash
sudo -u postgres createuser euser -P
sudo -u postgres createdb e_inscription -O euser
```

Mettre à jour le fichier `.env` :
> Note : Modifiez l'utilisateur et le mot de passe selon ce que vous avez défini précédemment

```
DATABASE_URL="postgresql://euser:motdepasse@127.0.0.1:5432/e_inscription?serverVersion=15.8&charset=utf8"
```

### 4. Vérifier la connexion

```bash
php bin/console app:check-database-connection
```

### 5. Configurer Nginx

#### Installation de Nginx

**Étape 1 : Installer Nginx**

```bash
sudo apt update
sudo apt upgrade
sudo apt install nginx
sudo systemctl status nginx
```

**Étape 2 : Installer PHP et PHP-FPM**

```bash
sudo apt install php-fpm php-mysql php-xml php-mbstring php-curl php-intl php-zip
sudo systemctl status php8.2-fpm
```

**Étape 3 : Configurer Nginx pour Symfony**

Créer le fichier de configuration :

```bash
sudo nano /etc/nginx/sites-available/e-inscription
```

Mettre à jour le fichier `.env` :
> Note : Modifiez l'utilisateur et le mot de passe selon ce que vous avez défini précédemment

```
DATABASE_URL="postgresql://euser:motdepasse@127.0.0.1:5432/e_inscription?serverVersion=15.8&charset=utf8"
```

### 4. Vérifier la connexion

```bash
php bin/console app:check-database-connection
```

### 5. Configurer Nginx

#### Installation de Nginx

**Étape 1 : Installer Nginx**

```bash
sudo apt update
sudo apt upgrade
sudo apt install nginx
sudo systemctl status nginx
```

**Étape 2 : Installer PHP et PHP-FPM**

```bash
sudo apt install php-fpm php-mysql php-xml php-mbstring php-curl php-intl php-zip
sudo systemctl status php8.2-fpm
```

**Étape 3 : Configurer Nginx pour Symfony**

Créer le fichier de configuration :

```bash
sudo nano /etc/nginx/sites-available/e-inscription
```

Voici un exemple de configuration :

```nginx
server {
    listen 80;
    server_name e-inscription.com;

    # Répertoire racine pour Symfony (doit pointer vers le dossier public)
    root /var/www/E-Inscription/public;
    index index.php index.html;

    # Gestion des requêtes vers index.php pour Symfony
    location / {
        try_files $uri /index.php$is_args$args;
    }

    # Redirige les requêtes vers index.php pour Symfony
    location ~ ^/index\.php(/|$) {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;  # Remplacez avec votre version de PHP
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_intercept_errors on;
        fastcgi_param HTTP_CACHE_CONTROL "no-cache";
    }

    # Gestion des erreurs 404
    error_page 404 /index.php;

    # Sécuriser l'accès aux fichiers sensibles
    location ~* \.(env|yaml|yml|twig|json|md|dist|lock)$ {
        deny all;
    }

    # Désactiver l'accès aux fichiers .ht*
    location ~ /\.ht {
        deny all;
    }

    # Protéger contre les attaques de clickjacking
    add_header X-Frame-Options "SAMEORIGIN" always;

    # Protéger contre les attaques de type MIME sniffing
    add_header X-Content-Type-Options "nosniff" always;

    # Protéger contre les attaques de cross-site scripting
    add_header X-XSS-Protection "1; mode=block" always;

    # Protéger les informations de la version du serveur
    server_tokens off;

    # Cache pour les fichiers statiques
    location ~* \.(jpg|jpeg|png|gif|css|js|ico|woff|woff2|ttf|svg|eot|otf|mp4|webp)$ {
        expires 30d;
        access_log off;
    }

    # Autoriser l'upload de fichiers via PHP
    client_max_body_size 10M;  # Limite la taille de fichier uploadé à 10Mo (modifiable)
}
```

Configuration avec SSL (optionnelle) :

```nginx
# Configuration SSL (si vous utilisez HTTPS)
server {
    listen 443 ssl;
    server_name e-inscription.com;
    
    # Répertoire racine et autres configurations comme ci-dessus
    root /var/www/E-Inscription/public;
    # [...autres configurations identiques...]
    
    # Certificats SSL
    ssl_certificate /etc/ssl/certs/votre_certificat.crt;
    ssl_certificate_key /etc/ssl/private/votre_certificat.key;

    # Paramètres SSL recommandés
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers 'ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES128-GCM-SHA256';
    ssl_prefer_server_ciphers off;
    ssl_dhparam /etc/ssl/certs/dhparam.pem;
}
```

Activer le site et redémarrer Nginx :

```bash
sudo ln -s /etc/nginx/sites-available/e-inscription /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

**Étape 4 : Définir les permissions correctes**

```bash
sudo chown -R www-data:www-data /var/www/E-Inscription
sudo chmod -R 755 /var/www/E-Inscription
```

### 6. Créer le schéma et lancer les migrations

```bash
php bin/console doctrine:database:create
php bin/console make:migration  
php bin/console doctrine:migrations:migrate
```

### 🔐 Configuration Microsoft Azure (OAuth / API Graph)

Pour que l’application puisse interagir avec l’API de Microsoft, vous devez configurer une application dans Azure et récupérer les identifiants nécessaires : `clientId`, `tenantId`, `clientSecret`.

#### Étapes pour récupérer le `clientSecret` dans Azure

1. Connectez-vous au [portail Azure](https://portal.azure.com) avec le compte inscription@lyceefulbert.fr .
2. Allez dans **Azure Active Directory** dans la barre de recherche > **Gérer** > **Inscriptions d'applications**.
3. Cliquez sur **New registration** pour créer une application, ou sélectionnez une application existante.
4. Dans la colonne de gauche, cliquez sur **Certificats & secrets** dans **Gérer**.
5. Sous l’onglet **Secrets Client**, cliquez sur **Nouveau client secret** :
   - Donnez un nom explicite (par exemple `SymfonyMailerSecret`).
   - Choisissez une période d’expiration : `6 mois`.
   - Cliquez sur **Add**.
    Ou si le **Secrets Client** existe et que le certificat expire bientôt il faudra tout de même en crée un nouveau
6. Une fois généré, **copiez immédiatement la valeur** dans la colonne **Valeur**.
   > ⚠️ Elle ne sera plus visible après avoir quitté la page.

#### Environnement à configurer

```env
AZURE_CLIENT_ID="votre-client-id"  # déjà présent dans le .env
AZURE_TENANT_ID="votre-tenant-id"  # déjà présent dans le .env
AZURE_CLIENT_SECRET="votre-secret"   # à modifier tout les 6 mois dans le .env
```

### Ajout des informations clients sur le .env

les informations se trouvent dans notre équipe teams : Master Corp, les informations pour l'envoie de mail se trouve dans la publication, la publication se trouve epinglé

## 📦 Autres commandes utiles

**Lancer les tests :**

```bash
php bin/phpunit
```

**Créer un utilisateur administrateur (si applicable) :**

```bash
php bin/console app:create-admin
```

## 🔍 Dépannage courant

- Si vous rencontrez des problèmes de permissions, vérifiez que les dossiers `var/cache` et `var/log` sont accessibles en écriture.
- Pour les problèmes liés à la base de données, assurez-vous que PostgreSQL est correctement configuré et que l'utilisateur dispose des droits nécessaires.
- En cas d'erreurs avec Nginx, consultez les logs : `sudo tail -f /var/log/nginx/error.log`
- Si vous rencontrez des erreurs liées aux extensions PHP manquantes, vérifiez que toutes les extensions requises sont activées dans votre fichier php.ini.
