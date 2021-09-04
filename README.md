## How to install

This app has done using laravel and vuejs

To set up those app please follow

- Clone the project https://github.com/4kasun/gap-tmpr.git
- Go to the project directory
- Duplicate .env.exmple file to .env for linux and mac use this command
```
cp .env.example .env
```
- Update the .env file with relevant database credentials
```DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<db name>
DB_USERNAME=<db username>
DB_PASSWORD=<db password>
```
- Run following commands
```
composer install  # will install all laravel dependancies

php artisan key:generate

php artisan migrate  # To create database tables

php artisan passport:install  # To create passport keys

npm install  # To install vue js packages
```

## How to Run project

To run the project you should run followin g two command in seperate terminal for get dev environment

```
php artisan serve
```

```
npm run  watch
```

## Open the project

Now open your web browser and go to the

```
http://loclahost:8000
```

Now create a account by filling the register form and loging.