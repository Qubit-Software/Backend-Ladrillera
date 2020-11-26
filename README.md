# Backend-Ladrillera

Backend Ladillera

## Pasos uso de API de forma local.

1.  Instalar XAMP/WAMP/LAMP en la maquina para tener MYSQL y PhpMyAdmin
    - [XAMP](https://www.apachefriends.org/es/download.html)
2.  Instalar composer para administrar dependencias de Php y Laravel

    1.  https://getcomposer.org/download/  
        Y añadir a las variables de entorno del sistema si no esta.
    2.  Probar composer en la terminal
        > $ composer -V

3.  Abrir el PhpMyadmin o Workbench y ejecutar el codigo sql dentro del archivo "database.sql" y "users.sql".
4.  Re nombrar archivo env.example a .env y en ese archivo .env del proyecto cambiar credenciales de acceso a la base de datos MYSQL por los nuevos.
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ladrillera
    DB_USERNAME=dbuser
    DB_PASSWORD=dbuser_pw
    ```
5.  Ejecutar el siguiente comando dentro del Proyecto Laravel para instalar las dependencias.
    > $ composer install  
    > $ compose update  
6.  Correr migraciones para el Proyecto Laravel junto con passport.
    1.  Migrar base de datos
        > php artisan migrate
    2.  Generar nuevas keys para passport con este flag si da error "--force"
        > php artisan passport:install  
        > php artisan key:generate
    3.  Llenar base de datos con datos de admin y estaticos
        > php artisan db:seed
7.  Iniciar proyecto Laravel
    > php artisan serve
8.  Iniciar servidor de websockets
    > php artisan websockets:serve


Para documentacion referirse a espacio de trabajo en POSTMAN.

&nbsp;  
&nbsp;  
&nbsp;

# TODO

Setup Docker Containers
[Laravel in Docker docs](https://buddy.works/guides/laravel-in-docker?utm_source=medium&utm_medium=post&utm_campaign=laravel-in-docker&utm_content=link)


Create models

> php artisan make:model Models/Documento


Create controllers

> php artisan make:controller PhotoController --resource --model=Models\Photo

Crear enlaces simbolicos para el almacenamiento  

>  php artisan storage:link

Crear exceptions

> php artisan make:exception ValidationException


./ngrok authtoken 4AZuo6YDSB7Y9DqM9gki3_7xPchVKGvueoRfyHBaPjo