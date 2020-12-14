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

3.  Abrir el PhpMyadmin o Workbench y ejecutar el codigo sql dentro del archivo "L21_database.sql", "L21_default_data" y "L21_users.sql".
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

> php artisan make:model Models/DocumentoModel

Create controllers

> php artisan make:controller PhotoController --resource --model=Models\Photo

Crear enlaces simbolicos para el almacenamiento

> php artisan storage:link

Crear exceptions

> php artisan make:exception ValidationException

./ngrok authtoken 4AZuo6YDSB7Y9DqM9gki3_7xPchVKGvueoRfyHBaPjo

Tinker para los sockets

> php artisan tinker
> event(new App\Events\EventoNotificacionGeneral('Hola'));
> event(new App\Events\EventoNotificacionGeneral("Holssssa", "Body ....", "/notificaciones", "Bajo", "Baja"));


Guadar archivo con curl desde linux shell  

> .... -o salida.pdf

Ejemplo:
> curl --location --request GET 'http://d33e7941e58a.ngrok.io/api/documentos/clientes/2/zip' --header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI1IiwianRpIjoiMTkxMWM3MTgxOGUzZjljMjcwNmE5MzY3ODIyOGFmNDdlMmJmMWY1NmM3MmFjM2IyY2Q2ZmIyNjE4MDg1ZDg5YzU5MTZhODRhZjRkZjE2OTUiLCJpYXQiOjE2MDc2NjA4NTMsIm5iZiI6MTYwNzY2MDg1MywiZXhwIjoxNjM5MTk2ODUzLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.j0wsqdrMa7TH_EOBnBRxFPrrfJ9aH5fWbt4bjA7_NXCx0GxCd6oQf2Kc5k3Bp4spPswOBLhf5KRQJ52ylraVFi-CC8XeuWlwAvMKrC2WcN4c-4dTzE5V1RNtcVUhUAivuPS5ZcyeLceE_ong0kjvgUhbcMFQLFxgnQRVLWQ2UCMCZz_fQF-Q4qLt2l8ov4oS7fzZFk5SMG2PwgoZcnjMIgQ9C9fjIKrWenCOh6o0s2pEXIpsuhNGuyXpZ1tMu42hn-A3_hXzhzwgsOWp6ZUDzJg-0kJbf0--upGhmyu4jIcBloHqEQYJXBPiTgfF4ZWLEWyeIHdO9Y6o3pJzsZDGacaqZ6E645jbt_AZ0b5SkGaFSVczU9AYj7Wa0R-kpLPjcHSvRNwGRIs0ZRpSzMugxR2xhDPn4FEZDIou7jeAZtH5c9Fj81spRTiJ145I_Hrla9LrI_XITVZ0VZenGZdq4YolulmeneGd4RFPD6uHamyqebMcSp53PUJPsdQAPNBhrGYfV-XRslu1TfqkAhzD2dNCbUoaqcurg0vabN8Ua5QqywEOXvUupLf3PIMe-cao85w-ZSltxUGgLdq3C86IUtSna7ZUT2_SXa4Z9-wLbrvec_YmU48qW8FmS-QMb658kz8ndYvJsWGcQhwKiIRjo5oD8H-NMUMB90fDCIcIqD4' --header 'Content-Type: application/json' --data-raw '{   "cc_nit_cliente": "1251235654"}' -o salida.zip