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