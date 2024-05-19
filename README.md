# Proyecto PWD Final
**Francisco Insua FAI-3013**

## Introducción

Este es mi proyecto final para Programación Web Dinámica. Es un e-commerce de gorras.
## Funcionalidades ##
- Autenticación
- Control de sesiones
- Simulación de compra
- Seguimiento de compra
- Envío de mails al producirse un cambio de estado en la compra
- Gestión de ventas
- Gestión de productos
- Gestión de roles
- Gestión de usuarios

## Requisitos

Asegúrate de tener instalados los siguientes componentes:

- [XAMPP](https://www.apachefriends.org/index.html) (o cualquier otro servidor local con PHP y MySQL)
- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/)
- [phpMyAdmin](https://www.phpmyadmin.net/)

## Instalación

Sigue estos pasos para configurar el proyecto en tu entorno local:

### 1. Clona el repositorio: ###

Abre una consola y ejecuta:
```
cd C:/xampp/htdocs
```
```
git clone https://github.com/frankitobienslow/pwd-final.git
```
```
cd pwd-final
```


### 2. Instalar dependencias de composer: ###
   
Abre una consola y ejecuta:
```
composer install
```

### 3. Configura la base de datos ###
- Abre phpMyAdmin desde XAMPP *(normalmente en http://localhost/phpmyadmin)*.
- Crea una nueva base de datos con el nombre "bdcarritocompras"
- Importa el bdcarritocompras.sql ubicado en /bdcarritocompras.sql para crear las tablas y datos necesarios.

### 4. Inicia Apache y MySQL desde el panel de control de XAMPP. ###

### 5. Accede al proyecto en tu navegador web en http://localhost/pwd-final/vista/inicio/inicioIndex.php. ###

