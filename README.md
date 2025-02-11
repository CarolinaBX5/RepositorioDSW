# 🌟 Proyecto UT6 – Valoración con estrellas

## 📝 Descripción del Proyecto
Este proyecto implementa un sistema de votación con estrellas ⭐ en una página de productos. Cualquier cliente validado podrá calificar un producto con una puntuación del 1 al 5. Las valoraciones se actualizarán en tiempo real mediante **Xajax**, evitando que un mismo usuario valore un producto más de una vez.

Las principales funcionalidades incluyen:
- 🔑 Página de **Login** con validación de errores mediante **Xajax**.
- 📊 Función en **PHP** para registrar votos y devolver la media de valoraciones.
- ⭐ Función para mostrar la cantidad de votos y la puntuación promedio.
- 🎨 Uso de **Font Awesome** para la representación de las estrellas.
- 🗄️ Base de datos para almacenar las valoraciones de los productos.

## 🛠️ Tecnologías Utilizadas
- 🐘 **PHP** (Backend y lógica de negocio)
- ⚡ **Xajax** (Para actualizaciones en tiempo real sin recargar la página)
- 📜 **JavaScript** (Interacción en el frontend)
- 🛢️ **MySQL** (Base de datos para almacenar usuarios y votos)
- 🎨 **HTML y CSS** (Estructura y estilos de la aplicación)
- ⭐ **Font Awesome** (Íconos de estrellas para las valoraciones)
- 🖥️ **Visual Studio Code** (Entorno de desarrollo)

## 📌 Instrucciones de Instalación y Ejecución
### 🔹 Requisitos previos
- Tener un entorno **AMP** instalado (Apache, MySQL y PHP). Se recomienda **XAMPP** o **WAMP**.
- Configurar **Xdebug** en PHP para depuración.
- Tener **Visual Studio Code** con la extensión **PHP Debug** instalada y configurada.
- Un navegador con acceso a Internet.

### 📥 Instalación
1. **📂 Clonar el repositorio** o descargar los archivos del proyecto.
2. **🛢️ Configurar la base de datos:**
   - 📌 Importar el archivo `votos.sql` en MySQL para crear la tabla de votos.
   - 📌 Asegurar que la tabla de **usuarios** ya esté creada y contenga datos de prueba.
3. **⚙️ Configurar la conexión a la base de datos:**
   - ✏️ Editar el archivo `conexion.php` y modificar las credenciales de acceso a MySQL.
4. **🚀 Ejecutar el proyecto:**
   - 📂 Colocar los archivos en la carpeta raíz de tu servidor local (`htdocs` en XAMPP).
   - ▶️ Iniciar Apache y MySQL desde el panel de control de XAMPP.
   - 🌍 Acceder en el navegador a `http://localhost/proyecto/listado.php`.

### 🎯 Uso
- 🔑 Iniciar sesión con un usuario válido.
- ⭐ Valorar un producto haciendo click en las estrellas.
- 🔄 Ver cómo la valoración se actualiza en tiempo real sin recargar la página.
- 🚫 Intentar votar dos veces para comprobar que el sistema lo impide.
- 🔐 Cerrar sesión y probar con otro usuario.


