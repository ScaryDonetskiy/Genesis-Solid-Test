genesis-solid-test
==================

How to setup & run
-
- Clone project
- Install composer dependencies and enter application parameters in wizard
```text
composer install
```
- Create database by console command
```text
php bin/console doctrine:database:create
``` 
- Apply all migrations
```text
php bin/console doctrine:migrations:migrate
```
- Run server
```text
php bin/console server:run
```
