# WeWelcomPrueba

API RESTful para la gestión de restaurantes, desarrollada con Symfony 7 y API Platform.

## Descripción

WeWelcomPrueba es una API RESTful que permite gestionar una base de datos de restaurantes, con funcionalidades para crear, listar, actualizar y eliminar registros de restaurantes. Incluye un frontend básico con HTML, CSS y JavaScript para interactuar con la API.

## Tecnologías utilizadas

- PHP 8+  
- Symfony 7  
- API Platform  
- MySQL  
- Frontend básico con HTML, CSS y JavaScript (Fetch API)  

## Instalación

Sigue estos pasos para poner en marcha el proyecto localmente:

1. Clona el repositorio:

   git clone https://github.com/DanielBraca7/WeWelcomPrueba.git  
   cd WeWelcomPrueba

2. Instala las dependencias de PHP con Composer:

   composer install

3. Configura las variables de entorno:

   Crea un archivo `.env.local` basado en `.env` y ajusta la conexión a la base de datos, por ejemplo:

   DATABASE_URL="mysql://root:@127.0.0.1:3306/DBWWelcome"

4. Importa la base de datos:

   - Abre phpMyAdmin (u otra herramienta de gestión MySQL).
   - Crea una base de datos llamada `DBWWelcome` (o el nombre que hayas puesto en `DATABASE_URL`).
   - Importa el archivo `.sql` que encontrarás en la carpeta `documentos` del proyecto.

5. Usuario por defecto para pruebas:

   - Correo: test@gmail.com  
   - Contraseña: 1234

   También puedes registrar nuevos usuarios mediante el endpoint de registro.

## Uso

Para ejecutar la aplicación localmente, abre una terminal en la raíz del proyecto y ejecuta:

   php -S localhost:8000 -t public

Luego, abre tu navegador y visita:

- Aplicación frontend: http://localhost:8000  
- En caso de problemas, intenta acceder directamente al archivo HTML: http://localhost:8000/rest.html  
- Documentación de la API (Swagger UI): http://localhost:8000/api/docs  

## Contacto

Si tienes dudas o sugerencias, no dudes en contactarme:

- Email: bracadaniel07@outlook.com
