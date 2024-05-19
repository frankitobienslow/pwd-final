# Proyecto PWD Final
**Francisco Insua FAI-3013**

## Introducción

Este es mi proyecto final para Programación Web Dinámica. Es un e-commerce de gorras. Incluye funcionalidades como autenticación, control de sesiones, simulación de compra, gestión de ventas, productos, roles y usuarios, ademas de envío de mails automáticos al actualizarse el estado de una compra.

## Requisitos

Asegúrate de tener instalados los siguientes componentes:

- [XAMPP](https://www.apachefriends.org/index.html) (o cualquier otro servidor local con PHP y MySQL)
- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/)

## Instalación

Sigue estos pasos para configurar el proyecto en tu entorno local:

1. **Clona el repositorio:**

Abre una consola y ejecuta:
cd C:/xampp/htdocs
git clone https://github.com/frankitobienslow/pwd-final.git
cd pwd-final


2. **Instala dependencias de composer:**
   
Abre una consola y ejecuta:
  composer install

3. **Configura la base de datos**
Abre phpMyAdmin desde XAMPP (normalmente en http://localhost/phpmyadmin).
Crea una nueva base de datos con el nombre "bdcarritocompras"
Importa el archivo SQL ubicado en /bdcarritocompras.sql para crear las tablas y datos necesarios.

4. **Inicia Apache y MySQL desde el panel de control de XAMPP.**

5. **Accede al proyecto en tu navegador web en http://localhost/pwd-final/vista/inicio/inicioIndex.php.**

