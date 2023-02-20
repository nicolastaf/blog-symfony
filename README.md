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
Le .env.local est nécessaire pour le moment à creuser avec le fichier Dockerfile et Makefile

### Lancer symfony

- symfony server:start -d ou symfony serve -d
  
### Lancer docker
- Lancer Docker sur la machine
- docker-compose up -d
- docker-compose ps (permet d'avoir les infos nom de l'image, service, ports...)

### Stopper docker

- docker-compose down ou stop

## Pour le smigartions

Il faut utiliser la commande symfony au lieu de php bin/console.

## Requête affiche d'articles par catégories

```bash
SELECT * FROM `post` INNER JOIN category ON post.categories_id = category.id WHERE category.id = 2
```

## Requête affiche les articles par author

```
 SELECT * FROM `post` INNER JOIN author ON post.author_id = author.id WHERE author.id = 2
 ```