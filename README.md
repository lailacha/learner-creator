# Learner creator

## How to setup the project

### Clone the Project
`git clone git@github.com:lailacha/learner-creator.git`

### Build docker container
`docker-compose up -d`  </br> </br>
This command will create the docker container and its images (Apache server, Phpmyadmin, MYSQL)

### Define environment variables

You need to define some variables to use databases. </br>

Define variables in _conf.inc.php_ file like that:

```<?php
define("DBDRIVER", "mysql");
define("DBUSER", "root");
define("DBPWD", "password");
define("DBHOST", "database");
define("DBNAME", "database_name");
define("DBPORT", "3306");
define("DBPREFIXE", "esgi_");
```

### Got to **_@http://localhost:8080/_**
The project is ready :tada:




### Design Paterns 

Le décorator:

Définition: 

Comme le nom l'indique les décorateurs vont "décorer"
un objet en y ajoutant des méthodes ou en modifiant le comportement de méthodes existantes.

L'objectif du decorator est de pouvoir modifier le comportement de la classe suivant certains cas ou de rajouter des foncionnalité.

Cas d'utilisation:

La classe InstalleurGreeting  permet d'accueillir nos visiteurs en leur souhaitant la bienvenue.
La class Error permet ainsi de modifier le comportement de la fonction greeting lorsque l'aplication est déjà installer.

Emplacement:

www/Core/Decorator.class.php
www/Core/InstalleurGreeting.class.php
www/Core/Error.class.php


L'observer

Définition:

L'oberver permet de mettre en place simplementun mécanisme de notification. En ayant un objet observé et un observateur. On va avoir des suscribers à un evenement et ceux-ci seront alerté si besoin. On

Cas d'utilisation:

Ici, nous utilison l'observateur pour observer chaque création de cours afin d'alerter les users qui ont ajouté cette catégorie de cours à leur préférences par mail. 
Avec le modèle MVC et le fonctionnement de notre appplication, il était compliqué de créer un observer classique. Nous avons donc ici un semblant d'observateur mais il n'utilise pas les interfaces classiques.

Emplacement:

www/Model/User.class.php => fonction update
www/Model/Course.class.php => fonction notify et save

Le query builder

Définition:
Le Query Builder est un objet qui permet de simplifier la création de requêtes SQL grâce à des méthodes génériques.


Emplacement:
www/core/MysqlBuilder.class.php
Vous allez trouver un exemple d’utilisation dans l’index.php


Le singleton

Définition:

Le Singleton est utilisé  dans le but de limiter le nombre d’instance d'une classe afin de pouvoir réutiliser la même instance (au lieu d'en créer une non nécessaire).

Cas d'utilisation:
Ici nous instancions une fois l'objet PDO afin de garder la même connection à la base de données et ainsi éviter les multiples instances.

Emplacement:

 www/Core/Sql.class.php