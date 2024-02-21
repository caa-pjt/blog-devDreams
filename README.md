# MAS-RAD FRM mini projet - Blog Dev Dreams

## Objectif

- Ce projet a pour objectif de developer une interface permettant de créer des
  articles et de les associer à une catégorie.
- Seul l'utilisateur (admin) peut administrer le site.

## Installation

### Récupération du projet

1. Cloner dépôt :

```bash
https://github.com/caa-pjt/blog-devDreams.git
```

2. Installer laravel sail :

```bash
cd blog-devDreams
docker run --rm --interactive --tty   --volume $PWD:/app   --user $(id -u):$(id -g)   composer install
```

3. Mettre à la racine le fichier .env du projet (le renommer en .env au lieu de .env.txt) :

4. Démarrer docker et créer les conteneurs :

```bash
./vendor/bin/sail up
```

5. Démarrer Vitejs :

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

6. Accéder à la page : http://localhost

7. Cliquer sur "Run migrations" puis "Refresh" et l'app doit fonctionner

### Ajouter des fausses données à la DB

```bash
./vendor/bin/sail artisan db:seed
```

### Tester l'application

```bash
./vendor/bin/sail artisan test
```
