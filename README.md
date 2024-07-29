composer dump-env dev // a faire a chaque modif de .env
symfony console d:d:c ou symfony console doctrine:database:create // pour créer une databse sur Mysql
symfony console list // pour voir la liste des commandes disponibles

symfony server:start // pour démarrer le server symfony
symfony server:stop ou ctrl + c // pour couper le server

symfony console make:entity Categorie // pour créer le CRUD entity pour la perssistance et repository pour le read
symfony console make:migration // pour préparer le fichier de migration en BDD
symfony console d:m:m  ou symfony console doctrine:migrations:migrate // pour faire la migration sur la BDD

symfony console make:controller Backend\ArticleController // pour créer un controller
php bin/console make:controller SecurityController // Créer le security controller pour accéder au BO
symfony console make:form puis ArticleType puis Article// pour créer un formulaire

symfony console debug:router // pour voir les routes et debuger si besoin

yarn watch // a lancer pour valider les modifications css ctrl + c pour couper yarn watch

 symfony console make --help // pour voir les commandes idem pour d'autres items que "make"
-------------------------------------------
https://localhost:8000/admin/articles
admin@test.com // Test1234
------------------------------------------

 {{ dump(app.request.get('_route'))  }}  // nom de la route sur laquel tu est

 -----------------------------------------
 Pour faire le CRUD il faut:
 - créer l'entity
 - make:migration et doctrine migrations:migrate
 - Backend nomController( index, update, delete)
 - faire les vues twig ( templates/ backend/frontend FichierNom nom.html.twig)