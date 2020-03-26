# Laradock Utils
Opinionated easy way to generate and remove sites in laradock

## New docker in Windows
Add to a .gitignore global `/laradock-*`
In a (windows) shell
`
cd myproject
git clone https://github.com/laradock/laradock.git laradock-myproject
cd laradock-myproject
cp env-example .env
`
Modify in .env this values:
`
COMPOSE_PATH_SEPARATOR=;
COMPOSE_PROJECT_NAME=laradock-myproject
`

Modify in .env desired PHP_VERSION:
`
PHP_VERSION=7.4
`

Remember to create manually the database. To connect, these are the parameters:
`
DB_HOST=mysql
DB_USERNAME=root
DB_PASSWORD=root
`

Now start and ssh to the containers
`
docker-compose up -d nginx mysql
docker-compose exec workspace bash
`

To stop it:
`
docker-compose stop
`

## Create a site
`php generator.php --host=mysite.local --path=public --company=MYCOMPANY --country=ES`
then exit docker and restart it

## Remove a site
`php remover.php --host=mysite.local`
then exit docker and restart it
