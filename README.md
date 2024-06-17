# Hugo Assal
# Mathéo Grandjean
# Ismaël Koné
# Mathias Delcourt

Configuration du projet :

1. Cloner le projet Github sur votre machine
2. Créer un fichier .env à la racine du projet avec des valeurs pour MYSQL_PASSWORD, MYSQL_ROOT_PASSWORD, MYSQL_USER
3. A la racine du projet, tapez la commande "docker compose create", puis "docker compose start" pour utiliser le site de Giftbox
4. Allez dans le répertoire "src/" et tapez la commande "composer install" afin d'installer les dépendances du projet
5. Allez dans adminer à l'adresse "localhost:20007", connectez vous sur le serveur "sql.db" et avec les valeurs de connexions que vous avez saisis dans le fichier .env
6. Créer une base de données "giftBox", puis importez le fichier "sql/giftbox.schema.sql" et enfin le fihcier "sql/giftbox.data.sql"
7. Vous pouvez désormais utiliser le projet en local à l'adresse "localhost:20008"
