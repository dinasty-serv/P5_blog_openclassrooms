[![Codacy Badge](https://api.codacy.com/project/badge/Grade/5a86828f8a5545bc9d4c2818a2e00686)](https://app.codacy.com/gh/dinasty-serv/P5_blog_openclassrooms?utm_source=github.com&utm_medium=referral&utm_content=dinasty-serv/P5_blog_openclassrooms&utm_campaign=Badge_Grade)

Cloner le projet dans le répertoire WEB
git clone git@github.com:dinasty-serv/P5_blog_openclassrooms.git ./

Installer les dépendances
composer install

Installer la base de données sur votre serveur serveur MYSQL via phpmyadmin ou Mysql Workbench, le script de la base données se trouve dans le dossier sql/bdd.sql

Editer le fichier de configuration core/config/Config.php pour configurer la base de données et le serveur SMTP pour l'envoie d'email. 

Après avoir configurer le CMS, créer un compte puis rendez-vous dans la table users sur phpmyadmin ou mysql workbench pour modifier votre utilisateurs et lui assignier le role admin. 

Connectez-vous et vous devriez avoir accès au back-office du site.
