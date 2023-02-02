# blog-symfony
## Pour les recruteurs
Ce blog a pour objectif de vous montrer, ce que je suis capable de faire avec le frameWork Symfony et bootstrap.
L'autre but est de me maintenir dans la pratique en full stack.

### Forcer symfony à démarrer sur une version PHP de notre choix
exemple : 
- echo 8.1 > .php_version
- symfony serve -d
## Docker
Installation de docker desktop sur la machine
Le .env.local est nécessaire pour le moment à creuser avec le ficheir Dockerfile et Makefile
### Lancer symfony
- symfony server:start -d ou symfony serve -d
### Lancer docker
- docker-compose up -d
- docker-compose ps (permet d'avoir les onfos nom de l'image, service, ports...)
### Stopper docker
- docker-compose down ou stop

## Pour le smigartions
Il faut utiliser la commande symfony au lieu de php bin/console.