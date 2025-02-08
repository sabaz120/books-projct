# 📚 **Proyecto Laravel 11: Biblioteca Personal API**

## Descripción

Esta API **Laravel 11** está diseñada para almacenar información sobre **libros**, como el título, autor y un breve resumen, de manera personalizada por cada usuario. Imagina tener un espacio digital donde guardar las notas de los libros que deseas leer en el futuro. Esta API proporciona un backend sólido para construir aplicaciones móviles o web que permitan a los usuarios gestionar su lista de libros. 📖💡

## 🚀 **Características destacadas**

- **Estructura de API bien definida**: Organización de rutas y controladores por versión para una mejor mantenibilidad y escalabilidad.
- **Registro y autenticación de usuarios**: Implementación de un sistema robusto de registro y autenticación de usuarios utilizando **tymon/jwt-auth**.
- **Operaciones CRUD**: Cobertura completa de las operaciones CRUD (crear, leer, actualizar y eliminar) para los recursos de libros.
- **Form Requests**: Utilización de **Form Requests** para validar los datos de entrada en cada solicitud, garantizando la integridad de los datos.
- **Traits de respuesta API**: Abstracción de la lógica de respuesta en traits personalizados para evitar la repetición de código en los controladores.
- **Autorización**: Implementación de reglas de **autorización** para garantizar que los usuarios solo puedan acceder a los recursos que tienen permiso.

## 🛠 **Estructura del proyecto**

La estructura del proyecto está organizada de la siguiente manera:

- `app/Http/Controllers/Api/V1`: Contiene los controladores de la **versión 1** de la API.
- `app/Http/Requests`: Contiene los **Form Requests** para validar las solicitudes.
- `app/Traits`: Contiene los **traits personalizados** para las respuestas API.

## 🔑 **Funcionalidades principales**

- **Registro de usuarios**: Permite a nuevos usuarios crear una cuenta. 📝
- **Autenticación de usuarios**: Verifica la identidad de los usuarios para proteger sus datos. 🔒
- **CRUD de libros**: Ofrece operaciones de creación, lectura, actualización y eliminación de registros de libros para cada usuario. 📚

## 🛠 **Requisitos previos**

- **PHP**: Versión 8.4.1 o superior. 🖥️
- **Composer**: Un gestor de dependencias para PHP. 📦
- **Node.js y npm**: Para la gestión de assets frontend (si aplica). 🌐
- **Servidor web**: Apache, Nginx o cualquier otro compatible con PHP. 🌍

## 📥 **Instalación**

- **Clonar repositorio**

```bash
  git clone https://github.com/sabaz120/books-projct.git
  cd clients-projct
```
- **Instalar dependencias**
```bash
composer install
npm install
npm run build
```
- **Copiar y configurar el archivo .env:**
```bash
cp .env.example .env
```
- **Configura las credenciales de tu base de datos, la URL de la aplicación y otras variables de entorno necesarias.**


- **Generar la clave de la aplicación:**
```bash
php artisan key:generate
```
- **Ejecutar las migraciones:**
```bash
php artisan migrate
```
- **Iniciar el servidor de desarrollo:**
```bash
php artisan serve
```
## ⚡ Referencia API

#### Registro de usuario

```http
  POST /api/v1/user/register
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `name` | `string`   |**Required**|
| `email` | `string`   |**Required**|
| `password` | `string`   |**Required**|
| `password_confirmation` | `string`|**Required**|

#### Autenticación

```http
  POST /api/v1/user/login
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email`      | `string` | **Required**|
| `password`      | `string` | **Required**|

**Respuesta:** Un token de autenticación que debe incluirse en el encabezado Authorization de las siguientes solicitudes como Bearer ${token}.

#### Consulta de libros

```http
  GET /api/v1/books
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `take`      | `string` | **Cantidad de registros por página**|
| `search`      | `string` | **Término**|
| `justMyBooks`      | `string` | **Indica si solo se deben devolver los libros del usuario autenticado (1)**|

**Nota:** Requiere un token de acceso válido (Enviar el header, Authorization: Bearer ${token}.

#### Crear un libro

```http
  POST /api/v1/books
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`      | `string` | **Requerido**|
| `author`      | `string` | **Requerido**|
| `summary`      | `string` | **Requerido**|

**Nota:** Requiere un token de acceso válido (Enviar el header, Authorization: Bearer ${token}.

#### Actualizar un libro

```http
  PUT /api/v1/books/${id}
```
| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`      | `string` | **Opcional**|
| `author`      | `string` | **Opcional**|
| `summary`      | `string` | **Opcional**|

**Nota:** Requiere un token de acceso válido (Enviar el header, Authorization: Bearer ${token}.

#### Eliminar un libro

```http
  PUT /api/v1/books/${id}
```
**Nota:** Requiere un token de acceso válido (Enviar el header, Authorization: Bearer ${token}.
## Proyecto realizado como prueba técnica 

Este proyecto esta dirigido para:

- Alegra


## License

El marco Laravel es un software de código abierto con licencia bajo la [MIT license](https://opensource.org/licenses/MIT).
