# Séance d'Entraînement Symfony
## Objectif
Créer un projet Symfony de A à Z pour gérer les jours de congés de l'entreprise BTS-SIO-SLAM.

## Prérequis
- PHP >= 7.2.5
- Composer
- Symfony CLI
- Un éditeur de code (par exemple, VSCode)

## Étapes

### 1. Installation de Symfony CLI
Téléchargez et installez Symfony CLI depuis [le site officiel](https://symfony.com/download).

### 2. Création du Projet
Ouvrez votre terminal et exécutez la commande suivante :
```bash
symfony new gestion_conges --full
```

### 3. Configuration de l'Environnement
Naviguez dans le répertoire du projet :
```bash
cd gestion_conges
```
Copiez le fichier `.env` en `.env.local` et configurez vos paramètres de base de données.

### 4. Installation des Dépendances
Assurez-vous que toutes les dépendances sont installées :
```bash
composer install
```

### 5. Configuration de PostgreSQL avec Symfony

#### 5.1. Installer PostgreSQL
Si PostgreSQL n'est pas déjà installé, téléchargez l'installateur depuis [PostgreSQL Downloads](https://www.postgresql.org/download/).

#### 5.2. Installer l'extension `pdo_pgsql` pour PHP
Assurez-vous que l'extension `pdo_pgsql` est installée et activée. Sur Windows, modifiez le fichier `php.ini` pour décommenter :
```ini
extension=pdo_pgsql
```

#### 5.3. Configurer la connexion PostgreSQL dans Symfony
Modifiez le fichier `.env.local` pour ajouter les détails de connexion à PostgreSQL :
```dotenv
DATABASE_URL="postgresql://username:password@127.0.0.1:5432/gestion_conges"
```
Remplacez `username` et `password` par vos informations d'identification PostgreSQL.

#### 5.4. Créer la base de données
Exécutez la commande suivante :
```bash
php bin/console doctrine:database:create
```

### 6. Création des Entités

#### 6.1. Création de l'Entité Utilisateur
Générez une entité Utilisateur :
```bash
php bin/console make:entity User
```
Ajoutez les champs suivants : `id`, `nom`, `prenom`, `email`, `password`.

Vous pouvez également créer l'entité en une seule commande :
```bash
php bin/console make:entity User --fields="nom:string,email:string,password:string"
```

#### 6.2. Création de l'Entité Congé
Générez une entité Congé :
```bash
php bin/console make:entity Conge
```
Ajoutez les champs suivants : `id`, `dateDebut`, `dateFin`, `type`, `status`, `user` (relation avec l'entité User).

Utilisez cette commande pour créer l'entité rapidement :
```bash
php bin/console make:entity Conge --fields="dateDebut:datetime,dateFin:datetime,type:string,user:relation:ManyToOne"
```

### 7. Création des Contrôleurs

#### 7.1. Création du `UserController`
Générez un contrôleur pour gérer les utilisateurs :
```bash
php bin/console make:controller UserController
```
Ajoutez des routes et actions pour créer, lire, mettre à jour et supprimer des utilisateurs.

#### 7.2. Création du `CongeController`
Générez un contrôleur pour gérer les congés :
```bash
php bin/console make:controller CongeController
```

### 8. Configuration des Routes
Pas besoin avec les attributs `#[Route('/conge', name: 'app_conge')]`. La route `/conge` est associée à une certaine action ou méthode dans le contrôleur, et elle est nommée `app_conge`. Cela permet de simplifier la configuration des routes en les définissant directement dans le code, plutôt que dans un fichier de configuration séparé.

### 9. Création des Vues de Base
Créez les vues suivantes :

#### Vue Utilisateur
```twig
{# templates/user/index.html.twig #}
{% extends 'base.html.twig' %}

{% block title %}User{% endblock %}

{% block body %}
<h1>User</h1>
{% endblock %}
```

#### Vue Congé
```twig
{# templates/conge/index.html.twig #}
{% extends 'base.html.twig' %}

{% block title %}Congé{% endblock %}

{% block body %}
<h1>Congé</h1>
{% endblock %}
```

### 10. Exécuter les Migrations
Créez et exécutez les migrations pour la base de données :
```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

### 11. Tester la Base de Données
Récupérez les noms de tables dans le schéma 'public' de la base de données :
```bash
php bin/console doctrine:query:sql "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public';"
```

### 12. Installation de Symfony Foundry
Si ce n'est pas encore fait, installez Symfony Foundry, un outil pratique pour générer des entités et des données fictives :
```bash
composer require --dev orm-fixtures foundry
```

### 13. Générer la Classe UserFactory
Après avoir installé Foundry, vous devez créer une factory pour votre entité User. Vous pouvez générer une factory avec la commande suivante :
```bash
php bin/console make:factory User
```

### 14. Lancement du Serveur
Démarrez le serveur de développement Symfony :
```bash
symfony server:start
```
Accédez à votre application via `http://localhost:8000`.

### 15. CRUD pour la Gestion des Congés
Le projet inclut un système CRUD (Create, Read, Update, Delete) pour gérer les congés :

#### 15.1. Créer un Congé
- **Route** : `/conge/new`
- **Action** : Permet à un utilisateur de créer un nouveau congé via un formulaire.

#### 15.2. Lire la Liste des Congés
- **Route** : `/conge`
- **Action** : Affiche une liste de tous les congés dans la base de données, incluant des liens pour modifier ou supprimer chaque congé.

#### 15.3. Modifier un Congé
- **Route** : `/conge/{id}/edit`
- **Action** : Permet à un utilisateur de modifier un congé existant via un formulaire pré-rempli.

#### 15.4. Supprimer un Congé
- **Route** : `/conge/{id}/delete`
- **Action** : Permet à un utilisateur de supprimer un congé après confirmation.

### 16. Création des Vues de Base
Créez les vues suivantes :

#### Vue Utilisateur
```twig
{# templates/user/index.html.twig #}
{% extends 'base.html.twig' %}

{% block title %}User{% endblock %}

{% block body %}
<h1>User</h1>
{% endblock %}
```

#### Vue Congé
```twig
{# templates/conge/index.html.twig #}
{% extends 'base.html.twig' %}

{% block title %}Liste des Congés{% endblock %}

{% block body %}
<h1>Liste des Congés</h1>
<table class="table">
    <thead>
        <tr>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Type</th>
            <th>Utilisateur</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    {% for conge in conges %}
        <tr>
            <td>{{ conge.dateDebut|date('Y-m-d') }}</td>
            <td>{{ conge.dateFin|date('Y-m-d') }}</td>
            <td>{{ conge.type }}</td>
            <td>{{ conge.user.nom }}</td>
            <td>
                <a href="{{ path('conge_edit', {'id': conge.id}) }}">Modifier</a>
                <form method="post" action="{{ path('conge_delete', {'id': conge.id}) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce congé ?');">
                    <input type="hidden" name="_token" value="{{ csrf_token('delete' ~ conge.id) }}">
                    <button class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
    {% else %}
        <tr>
            <td colspan="5">Aucun congé trouvé</td>
        </tr>
    {% endfor %}
    </tbody>
</table>

<a href="{{ path('conge_new') }}">Ajouter un nouveau congé</a>
{% endblock %}
```

### 17. Tests et Débogage
Utilisez les outils de débogage intégrés et écrivez des tests pour vérifier le bon fonctionnement de votre application.

## Conclusion
Vous avez maintenant un projet Symfony fonctionnel pour la gestion des jours de congés. Continuez à explorer les fonctionnalités de Symfony pour enrichir votre application.

### License
Creative Commons pour le texte et MIT pour le code.
