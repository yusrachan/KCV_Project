# Utilisez l'image PHP 8.1
FROM php:8.1

# Installez les extensions PHP requises pour Symfony
RUN docker-php-ext-install pdo pdo_mysql

# Exécutez le conteneur en tant qu'utilisateur non root
RUN usermod -u 1000 www-data

# Définissez le répertoire de travail
WORKDIR /var/www/html

# Exécutez Composer pour installer les dépendances
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer