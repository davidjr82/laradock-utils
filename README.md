# Laradock Utils
Opinionated easy way to generate and remove sites in laradock


## New laradock in Windows

Add to a .gitignore global `/laradock-*`

In a (windows) shell
```bash
cd myproject
git clone https://github.com/laradock/laradock.git laradock-myproject
cd laradock-myproject
cp env-example .env
```
Modify in .env this values:
```bash
COMPOSE_PATH_SEPARATOR=;
COMPOSE_PROJECT_NAME=laradock-myproject
```

Modify in .env desired PHP_VERSION:
```bash
PHP_VERSION=7.4
```

Remember to create manually the database. To connect, these are the parameters:
```bash
DB_HOST=mysql
DB_USERNAME=root
DB_PASSWORD=root
```

Now start and ssh to the containers
```bash
docker-compose up -d nginx mysql
docker-compose exec workspace bash
```

To stop it:
```bash
docker-compose stop
```


## Create a site
Copy `generator.php` to the root folder `laradock-myproject` and then:
```bash
php generator.php --host=mysite.local --path=public --company=MYCOMPANY --country=ES
```

Add the ssl cert that it is in laradock-myproject\nginx\sites\mysite.local.conf as ca in your browser to make https works
Exit docker and restart it


## Remove a site
Copy `remover.php` to the root folder `laradock-myproject` and then:
```bash
php remover.php --host=mysite.local
```

Remove the ssl cert added (laradock-myproject\nginx\sites\mysite.local.conf) from ca in your browser
Exit docker and restart it
