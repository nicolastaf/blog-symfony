# Apprentissage sur Docker

## Forcer symfony à démarrer sur une version PHP de notre choix

exemple :
- echo 8.1 > .php_version
- symfony serve -d
  
## Docker

Installation de docker desktop sur la machine
Le .env.local est nécessaire. 
Voir le fichier Dockerfile et Makefile intéressant mais complexe à suivre...

### Lancer symfony server

- symfony server:start -d 
> _-d lance le serveur en background, si on ferme le terminal Apache et PHP continue de tourner_
  
### Lancer docker
- Lancer Docker sur la machine `docker-compose up -d`
- docker-compose ps (permet d'avoir les infos nom de l'image, service, ports...)

Pour stopper docker : `docker-compose down ou stop`

## Pour le smigartions

Il faut utiliser la commande `symfony` au lieu de `php bin/console`, c'est juste plus court je trouve ce n'est que mon avis.

## Requête affiche d'articles par catégories

```bash
SELECT * FROM `post` INNER JOIN category ON post.categories_id = category.id WHERE category.id = 2
```

## Requête affiche les articles par author idem à la précédente requête

```bash
 SELECT * FROM `post` INNER JOIN author ON post.author_id = author.id WHERE author.id = 2
 ```