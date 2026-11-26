#!/bin/sh
# Exécuté à chaque démarrage du conteneur, avant Apache.
set -e

echo "▶ Lien public vers les images envoyées"
php artisan storage:link --force >/dev/null 2>&1 || true

echo "▶ Migrations de la base de données"
php artisan migrate --force --no-interaction

echo "▶ Données de départ (rejouable sans doublon)"
php artisan db:seed --force --no-interaction

echo "▶ Mise en cache de la configuration et des routes"
php artisan config:cache
php artisan route:cache

echo "▶ Démarrage d'Apache"
exec "$@"
