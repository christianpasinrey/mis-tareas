# Mis Tareas

Este es un proyecto de ejemplo desarrollado con 
<br>
<img src="https://laravel.com/img/logomark.min.svg" height="200px" style="object-fit:cover;">
<img src="https://vuejs.org/images/logo.png" height="200px" style="object-fit:cover;">
<img src="https://pinia.esm.dev/pinia-logo.svg">
<br>
que muestra una aplicación simple de administración de tareas. Utiliza la librería Pinia para la gestión del estado de la aplicación entre los componentes que conforman el conjunto del panel de tareas.

## Clonar el repositorio

1. Asegúrate de tener instalado Git en tu sistema.
2. Abre tu terminal y navega hasta el directorio donde deseas clonar el repositorio.
3. Ejecuta el siguiente comando para clonar el repositorio:


git clone https://github.com/tu-usuario/mis-tareas.git

## Configuración

1. Navega hasta el directorio del proyecto clonado:

```bash
    cd mis-tareas
```

2. Instala las dependencias del proyecto utilizando Composer:
```bash
    composer install
```

3. Crea un archivo de configuración de entorno .env:

```bash
    cp .env.example .env
```

4. Genera una nueva clave de aplicación:
```bash
    php artisan key:generate
```
5. Configura la conexión a la base de datos en el archivo .env:
```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nombre_de_la_base_de_datos
    DB_USERNAME=usuario
    DB_PASSWORD=contraseña
```
6. Una vez que hayas completado los pasos de configuración, puedes iniciar la aplicación con el siguiente comando:
```bash
php artisan mistareas:start
```
Esto iniciará la aplicación de ejemplo con 10 usuarios predefinidos que se mostrarán en la consola justo después de introducir el comando para iniciar la aplicación. La contraseña para todos ellos será password.

Accede a la aplicación en tu navegador web utilizando la URL http://localhost:8000 y utiliza las credenciales de cualquiera de los usuarios predefinidos para iniciar sesión.


Recuerda reemplazar "tu-usuario" en la URL de clonación con tu nombre de usuario de GitHub, y ajustar la configuración de la base de datos según tus necesidades.

Si tienes alguna otra pregunta, no dudes en preguntar. ¡Buena suerte con tu proyecto!

