# Cómo ver tu Blog en el Navegador

¡Tu código parece estar listo! Solo te faltaba configurar cómo servir la aplicación, ya que el punto de entrada está en la carpeta `public` y no en la raíz.

## Opción 1: La forma más rápida (Recomendada)
Puedes usar el servidor integrado de PHP sin mover archivos ni configurar Apache.

1. Abre una terminal en la carpeta de tu proyecto (`d:\VisualStudio-workspace\ProyectoPHP`).
2. Ejecuta el siguiente comando:
   ```bash
   php -S localhost:8000 -t public
   ```
3. Abre tu navegador y ve a: [http://localhost:8000](http://localhost:8000)

## Opción 2: Usando XAMPP (Apache)
Si prefieres usar XAMPP, necesitas configurar un "Virtual Host" o ajustar la configuración, porque tu archivo `index.php` está dentro de `public`.

1. **Mover el proyecto**: Asegúrate de que la carpeta del proyecto esté dentro de `C:\xampp\htdocs` (o donde tengas instalado XAMPP).
2. **Acceder**: Si lo pones en `htdocs\ProyectoPHP`, intenta entrar a:
   [http://localhost/ProyectoPHP/public/](http://localhost/ProyectoPHP/public/)
   
   *Nota: Es posible que algunas rutas fallen si el enrutador no está configurado para subcarpetas. La Opción 1 es más segura para desarrollo.*

## Verificación de Base de Datos
Asegúrate de que tu configuración en `config/database.php` coincida con tu XAMPP:
- Usuario: `root`
- Contraseña: `Hola123` (En XAMPP por defecto suele venir vacía, verifica esto si te da error de conexión).
