# Proyecto PWD Final 2023
Autor: **Francisco Insua FAI-3013**

*Cursada en el segundo cuatrimestre de 2023*
## Introducción
Para el proyecto final de Programación Web Dinámica desarrollé un e-commerce de gorras.
## Funcionalidades ##
- Autenticación de credenciales *al loguearse/registrarse*
- Control de sesiones
- Simulación de compra (Cliente)
- Seguimiento de compra (Cliente) *Consultar el estado de la compra realizada*
- Envío de mails *Al producirse un cambio de estado en la compra*
- Gestión de ventas (Deposito) *Cambiar el estado de la venta, cancelar items*
- Gestión de productos (Deposito) *Agregar, deshabilitar y editar productos*
- Gestión de roles (Administrador) *Crear roles y editarlos (definir los permisos del rol)* 
- Gestión de usuarios (Administrador) *Asignar roles a usuarios y deshabilitarlos*
- Edición de perfil *Cambiar email, nombre y contraseña*
## Requisitos
Asegurate de tener instalados los siguientes componentes:
- [XAMPP](https://www.apachefriends.org/index.html) (o cualquier otro servidor local con PHP y MySQL)
- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/)
- [phpMyAdmin](https://www.phpmyadmin.net/)
## Instalación
Seguí estos pasos para configurar el proyecto en tu entorno local:
### 1. Cloná el repositorio: ###
Desde la consola ejecuta:
```
cd C:/xampp/htdocs
```
```
git clone https://github.com/frankitobienslow/pwd-final.git
```
```
cd pwd-final
```
### 2. Instalá dependencias de composer: ###
Desde la consola ejecuta:
```
composer install
```
### 3. Configurá la base de datos ###
- Abre phpMyAdmin desde XAMPP *(normalmente en http://localhost/phpmyadmin)*.
- Creá una nueva base de datos con el nombre "bdcarritocompras"
- Importá bdcarritocompras.sql ubicado en /bdcarritocompras.sql para crear las tablas y datos necesarios.
### 4. Iniciá Apache y MySQL desde el panel de control de XAMPP. ###
### 5. Accedé al proyecto en tu navegador web en http://localhost/pwd-final/vista/inicio/inicioIndex.php. ###
