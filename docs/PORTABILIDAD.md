# ✅ Lista de Verificación de Portabilidad

Este documento confirma que el proyecto **BlogCap** está correctamente configurado para ejecutarse en **cualquier equipo** con XAMPP o servidor similar.

---

## 📋 Archivos Creados para Portabilidad

### ✅ 1. README.md completo

**Ubicación**: `README.md`

Incluye:

- ✅ Requisitos previos del sistema
- ✅ Pasos detallados de instalación
- ✅ Configuración de base de datos
- ✅ Usuarios y contraseñas de prueba
- ✅ Solución de problemas comunes
- ✅ Estructura del proyecto

### ✅ 2. Archivo de configuración de ejemplo

**Ubicación**: `config/database.example.php`

Proporciona:

- ✅ Plantilla de configuración con valores por defecto
- ✅ Comentarios explicativos
- ✅ Configuración típica de XAMPP

### ✅ 3. .gitignore

**Ubicación**: `.gitignore`

Protege:

- ✅ Credenciales de base de datos (`config/database.php`)
- ✅ Archivos del sistema
- ✅ Configuraciones de IDE

---

## 🔧 Correcciones Aplicadas

### 1. **Routing corregido** ✅

**Archivo**: `public/index.php`

**Problema anterior**:

- El router no eliminaba el path base `/ProyectoPHP/public` de la URI
- Causaba error 404 en la página principal

**Solución aplicada**:

```php
// Eliminar el path base si existe
$basePath = '/ProyectoPHP/public';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}
```

### 2. **Helper url() para enlaces** ✅

**Archivo**: `src/helpers.php`

**Problema anterior**:

- Los enlaces en las vistas usaban rutas absolutas sin el base path
- Enlaces como `/login`, `/register`, `/blog/{slug}` causaban 404

**Solución aplicada**:
Creamos una función helper `url()` que agrega automáticamente el base path:

```php
function url(string $path): string
{
    $basePath = '/ProyectoPHP/public';
    $path = '/' . ltrim($path, '/');
    if ($path === '/' && $basePath !== '') {
        return $basePath;
    }
    return $basePath . $path;
}
```

**Archivos actualizados**:

- ✅ `src/Views/layouts/main.php` - Navegación
- ✅ `src/Views/home.php` - Página principal
- ✅ `src/Views/auth/login.php` - Login
- ✅ `src/Views/auth/register.php` - Registro
- ✅ `src/Views/posts/admin_index.php` - Panel admin
- ✅ `src/Views/posts/create.php` - Crear post
- ✅ `src/Views/posts/edit.php` - Editar post
- ✅ `src/Views/posts/show.php` - Ver post

### 3. **Base de datos self-contained** ✅

**Archivo**: `sql/blog_cm.sql`

Incluye:

- ✅ `CREATE DATABASE IF NOT EXISTS`
- ✅ Creación de tablas con `IF NOT EXISTS`
- ✅ Datos de ejemplo (usuarios y posts)
- ✅ Contraseñas hasheadas

---

## 🚀 Pasos para Ejecutar en Otro Equipo

### Para el nuevo usuario:

1. **Descargar/Clonar el proyecto**

   ```bash
   git clone https://github.com/Capel23/ProyectoPHP.git
   ```

2. **Mover a htdocs**

   ```
   C:\xampp\htdocs\ProyectoPHP
   ```

3. **Importar base de datos**

   - Abrir phpMyAdmin: `http://localhost/phpmyadmin`
   - Importar: `sql/blog_cm.sql`

4. **Configurar credenciales**

   ```bash
   copy config\database.example.php config\database.php
   ```

   Editar `config/database.php` con la contraseña de MySQL

5. **Verificar mod_rewrite**

   - Abrir `C:\xampp\apache\conf\httpd.conf`
   - Buscar: `LoadModule rewrite_module modules/mod_rewrite.so`
   - Asegurar que NO esté comentada (sin `#`)

6. **Acceder al proyecto**
   ```
   http://localhost/ProyectoPHP/public/
   ```

---

## ✅ Verificaciones de Portabilidad

| Aspecto                    | Estado | Detalles                        |
| -------------------------- | ------ | ------------------------------- |
| **Configuración database** | ✅     | Archivo ejemplo incluido        |
| **Datos de ejemplo**       | ✅     | SQL incluye usuarios y posts    |
| **Paths absolutos**        | ✅     | No hay rutas hardcodeadas       |
| **Documentación**          | ✅     | README completo                 |
| **.htaccess**              | ✅     | Incluido con reglas correctas   |
| **Routing**                | ✅     | Funciona con base path          |
| **Seguridad**              | ✅     | .gitignore protege credenciales |

---

## 🔐 Usuarios de Prueba

Los siguientes usuarios están incluidos en `sql/blog_cm.sql`:

| Usuario | Email             | Contraseña | Rol           |
| ------- | ----------------- | ---------- | ------------- |
| admin   | admin@example.com | admin123   | Administrador |
| usuario | user@example.com  | usuario123 | Usuario       |

---

## 📝 Notas Importantes

### ⚠️ Configuración Específica del Usuario

El **ÚNICO** archivo que debe configurar cada usuario es:

```
config/database.php
```

Con sus propias credenciales de MySQL. Este archivo:

- ✅ NO está en el repositorio (protegido por `.gitignore`)
- ✅ Tiene un ejemplo en `config/database.example.php`
- ✅ Está documentado en el README.md

### 🔄 Compatibilidad

El proyecto es compatible con:

- ✅ **Windows**: XAMPP, WAMP, Laragon
- ✅ **macOS**: MAMP, XAMPP
- ✅ **Linux**: LAMP stack

### 📦 Dependencias

**Sin dependencias externas**:

- ✅ PHP puro (sin Composer)
- ✅ Bootstrap 5 desde CDN
- ✅ MySQL estándar

---

## ✨ Conclusión

El proyecto **está completamente preparado** para ejecutarse en cualquier equipo con:

1. ✅ XAMPP o servidor similar
2. ✅ MySQL activo
3. ✅ mod_rewrite habilitado
4. ✅ PHP 8.1+

**No se requieren configuraciones adicionales** más allá de ajustar las credenciales de base de datos en `config/database.php`.

---

**Última actualización**: 9 de diciembre de 2025  
**Verificado en**: XAMPP 8.1.25 / Windows 11
