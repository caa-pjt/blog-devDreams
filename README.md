# MAS-RAD FRM mini projet - Blog Dev Dreams

## Objectif

- Ce projet a pour objectif de developer une interface permettant de créer des
  articles et de les associer à une catégorie.
- Seuls les utilisateurs enregistrés peuvent administrer le site.

## Installation

### Récupération du projet

1. Cloner dépôt :

```bash
git clone https://github.com/caa-pjt/blog-devDreams.git
```

2. Installer laravel sail :

```bash

```bash
cd blog-devDreams
docker run --rm --interactive --tty   --volume $PWD:/app   --user $(id -u):$(id -g)   composer install

# si error
docker run --rm --interactive --tty   --volume $PWD:/app   --user $(id -u):$(id -g)   composer install --ignore-platform-req=ext-bcmath
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

## Administrer l'application

### Créer un utilisateur pour l'application sans seed

1. route Get `create-user/{token}` : http://localhost/create-user/1234

    - Cette action va créer un utilisateur et le logger avec les identifiants suivants :

```bash
[
    'email' => 'john@doe.fr'
    'name' => 'John Doe',
    'password' => 'password'
]
```

> À ce stade, vous pouvez vous connecter avec ces identifiants mais, aucunes données ne sont présentes dans la DB.

### Ajouter des données manuellement en passant par le dashboard

1. Diriger vous vers la page du dashboard : http://localhost/dashboard
2. Cliquer sur "Catégories" pour ajouter une catégorie : http://localhost/admin/category
3. Cliquer sur "Articles" pour ajouter un article : http://localhost/admin/post

### Ajouter des fausses données à la DB grace aux seeds

- Completer la DB `./vendor/bin/sail artisan db:seed`
- Remise à 0 et seeds `./vendor/bin/sail artisan migrate:fresh --seed`

Ces commandes vont ajouter des données dans la DB pour les catégories et les articles ainsi qu'un nouvel utilisateur.

- Utilisateur :

```bash
[
    'email' => 'admin@gmail.com'
    'name' => 'Admin',
    'password' => '0000'
]
```

## Tester l'application

```bash
./vendor/bin/sail artisan test
```
