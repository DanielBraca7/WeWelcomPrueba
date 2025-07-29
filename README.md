# WeWelcomPrueba

API RESTful para la gestión de restaurantes, desarrollada con Symfony 7 y API Platform.

---

## Descripción

Este proyecto es una API RESTful que permite gestionar una base de datos de restaurantes, con funcionalidades para crear, listar, actualizar y eliminar restaurantes.

---

## Tecnologías

- PHP 8+  
- Symfony 7  
- API Platform  
- MySQL  
- Frontend básico con HTML, CSS y JavaScript (Fetch API)  

## Instalación

1. Clonar el repositorio:  
   git clone https://github.com/DanielBraca7/WeWelcomPrueba.git
   cd WeWelcomPrueba

2.Instalar dependencias PHP:
   composer install
   
3.Configurar variables de entorno en .env.local

DATABASE_URL="mysql://root:@127.0.0.1:3306/DBWWelcome"

4.Importar base de datos: 
Abre phpMyAdmin y accede a tu servidor MySQL.
Crea una nueva base de datos si lo deseas.
Selecciona la base de datos donde quieres importar los datos.
Ve a la pestaña Importar y selecciona el archivo .sql proporcionado en la carpeta documentos.

Haz clic en Continuar para iniciar la importación.

Usuario por defecto
Correo: test@gmail.com

Contraseña: 1234

Puedes registrar nuevos usuarios a través del endpoint de registro.

## Uso
Ejecutar por terminal desde la raiz del proyecto  
php -S localhost:8000 -t public

La aplicación será visible en tu navegador en la siguiente URL:
http://localhost:8000 

En caso de algún fallo, puedes intentar acceder directamente al archivo HTML en:
http://localhost:8000/rest.html

Documentación API disponible en:
http://localhost:8000/api/docs

## Contacto
Para dudas o sugerencias, contactame a bracadaniel07@outlook.com


