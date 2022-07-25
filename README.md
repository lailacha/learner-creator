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




### Disign Patern 

Le disign Patern:

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

