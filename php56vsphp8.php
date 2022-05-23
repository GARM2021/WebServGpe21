


VERSION XAMPP : 5.6.40 2019-03-08
PHP 5.6.40
SQL DRIVER : sqlsrv_56_ts_x64
Microsoft ODBC 11


VERSION XAMPP : 5.6.40 2019-03-08
PHP 5.6.40
SQL DRIVER : sqlsrv_56_ts_x64





-------------------------------------------------------------------------------------------------
D:\xampp\htdocs\WebServGpe21>php artisan -V
Laravel Framework 8.51.0
composer show
composer show -t
composer help
D:\xampp\htdocs\WebServGpe21>composer -V
Composer version 2.0.11 2021-02-24 14:57:23
------------------------------------------------------------------------------
XAMPP
Se bajo el xampp de la version de 5.6.40 
de 
https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/  

- se instalo
- se modifico 
- el PATH en SISTEMA - Configuraciones Avanzadas del sistema - Variables de entorno - Variables del Sistema - app_path
----------------------------------------------------------------------------------------------------
COMPOSER 
primero se bajo el 
composer.phar 
de: https://getcomposer.org/downlad/
"1.8.4  2019999-02-11"
se bajo el instalador de 
https://getcomposer.org/installer
lo baja como:
installer
se copio a 
C:\xampp5_6_40\htdocs\WS_GPE_5640
se renombro como 
composer-setup.php 
y se ejecuto 

C:\xampp5_6_40\htdocs\WS_GPE_5640>php composer-setup.php --filename=<composer.phar 
----------------------------------------------------------------------------------------------------
Version de laravel
en xampp\htdocs\WebServGpe21\composer.json
en el servidor 
"laravel/framework": "5.4.*",
----------------------------------------------------------------------------------------------------
Laravel
se installo con :

c:\xamp5_6_40\htdocs>composer create-project laravel/laravel WSGPE5640 "5.4.*"