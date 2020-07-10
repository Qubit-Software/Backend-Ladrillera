# Backend-Ladrillera

Backend Ladillera

## Pasos uso de API de forma local.

1.  Instalar XAMP/WAMP/LAMP en la maquina para tener MYSQL y PhpMyAdmin  
    -  [XAMP](https://www.apachefriends.org/es/download.html)    
2.  Instalar composer para administrar dependencias de Php y Laravel  
    1.  https://getcomposer.org/download/  
    Y añadir a las variables de entorno del sistema si no esta.
    2.  Probar composer en la terminal
          > composer -V    

3.  Abrir el PhpMyadmin y ejecutar el codigo sql dentro del archivo "database.sql"
4.  Para la base de datos de la ladrillera crear un usuario con permisos de consulta y escritura.
5.  Re nombrar archivo env.example a .env y en  ese archivo .env del proyecto cambiar credenciales de acceso a la base de datos MYSQL por los nuevos.  
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ladrillera
    DB_USERNAME=db_username
    DB_PASSWORD=db_username_password
    ```
6.  Ejecutar el siguiente comando dentro del Proyecto Laravel para instalar las dependencias.
    >  composer install  
7. Correr migraciones para el Proyecto Laravel junto con passport.
   1. Migrar base de datos
       > php artisan migrate
   2. Generar nuevas keys para passport con este flag si da error "--force" 
       > php artisan passport:install   
       > php artisan key:generate
8.  Iniciar proyecto
    >  php artisan serve  

Para documentacion referirse a espacio de trabajo en POSTMAN.

&nbsp;  
&nbsp;  
&nbsp;  

# TODO
Setup Docker Containers
[Laravel in Docker docs](https://buddy.works/guides/laravel-in-docker?utm_source=medium&utm_medium=post&utm_campaign=laravel-in-docker&utm_content=link)
