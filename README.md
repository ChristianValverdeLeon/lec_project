# RIFTY FANTASYLOL

**RIFTY FANTASYLOL** es una plataforma web desarrollada como parte de un proyecto final de grado, cuyo propósito es simular un sistema de Fantasy League basado en la liga profesional europea de *League of Legends* (LEC). El sistema permite a los usuarios registrarse, iniciar sesión, crear equipos virtuales, consultar estadísticas de jugadores y competir con base en su rendimiento.

La aplicación ha sido diseñada con un enfoque completo de desarrollo web full-stack, integrando tecnologías modernas tanto a nivel de frontend como de backend, y desplegada mediante contenedores Docker sobre un entorno controlado.



## Características principales

- **Autenticación de usuarios**: registro e inicio de sesión con interfaz desplegable e intuitiva.
- **Visualización de jugadores**: listado dinámico con filtros por rol y nombre.
- **Sistema de puntuación simulado**: asignación aleatoria de puntos y estadísticas (KDA).
- **Modo oscuro y traducción**: compatibilidad visual y traducción dinámica (ES/EN).
- **Diseño responsive**: compatible con ordenadores, tablets y móviles.
- **Despliegue contenerizado**: uso de Docker y NGINX para facilitar el despliegue y escalabilidad.

---

## Tecnologías utilizadas

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 8.x
- **Base de datos**: PostgreSQL
- **Servidor**: NGINX
- **Contenedores**: Docker & Docker Compose
- **Control de versiones**: Git + GitHub
- **Sistema operativo**: Ubuntu Server

---

## 📂 Estructura del Proyecto
El proyecto está organizado en distintos módulos para facilitar su mantenimiento, despliegue y escalabilidad. A continuación se describe cada parte del repositorio:

pagina-oficial/ – 🌐 Sitio web principal
Contiene el código fuente del frontend y la lógica del portal web:

index.php: Página de inicio con presentación del proyecto.

login.php, register.php, logout.php: Gestión de usuarios y sesiones.

jugadores.php: Visualización dinámica de jugadores con filtros.

reglas.php: Página informativa de normas del juego.

lol.ico: Ícono favicon personalizado.

assets/: Recursos estáticos como imágenes, íconos y hojas de estilo.

config/ – ⚙️ Configuración de base de datos
Contiene los parámetros de conexión y gestión con PostgreSQL:

db.php: Archivo central de configuración y conexión a la base de datos.

images/ – 🖼️ Avatares de Jugadores
Carpeta destinada a alojar las imágenes de los jugadores usados en el frontend.

panel-control/ – 🛠️ Panel de administración (opcional)
Sección prevista para gestionar usuarios, ligas, puntuaciones y supervisar el sistema.

proxy-externo/ – 🌍 Configuración de NGINX
Incluye archivos de configuración de NGINX como proxy inverso para enrutar el tráfico hacia el contenedor adecuado.

Archivos raíz del proyecto:
docker-compose.yml: Orquestador de los servicios del proyecto con contenedores.

Dockerfile: Imagen base para ejecutar el servidor web.

*.sh: Scripts auxiliares para iniciar, detener o mover el entorno del proyecto (detener.sh, mover.sh, etc).

---

Autores
Christian Valverde León. Mario Villarin Vaquerizo Hugo García Ortiz
Proyecto Final de Grado ASIR




