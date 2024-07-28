# File Transfer Web App

## Prerequisite
* Composer 2.0
* PHP 8.2+
* MySQL 
* This app may be highly usefull using Laragon on your OS

## How to run?
1. Install vendor needed for laravel via composer
```shell
composer install
```
2. You need app key for laravel application
```shell
php artisan key:generate
```
3. Run database migration
```shell
php artisan migrate
```
4. Link the storage for accessible file
```shell
php artisan storage:link
```
5. If not using Laragon, Serve your application via terminal
```shell
php artisan serve
```
6. If you are use laragon, locate the project in your laragon ``www`` folder and go to browse ``http://data-transfer.test``.

## Feature
1. Upload File
2. Delete File
3. Download File

## Tech Stack
* Laravel 11
* Bootstrap 5.3.3
* Vite 5.0
* iziToast 1.4
