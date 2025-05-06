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

## Estructura del proyecto
lec_project/
├── pagina-oficial/ # Código principal de la web
│ ├── index.php
│ ├── login.php
│ ├── register.php
│ ├── jugadores.php
│ ├── reglas.php
│ └── assets (favicon, imágenes)
├── config/ # Configuración de base de datos
├── proxy-externo/ # Configuración de NGINX como proxy
├── images/ # Avatares de jugadores
├── panel-control/ # Sección administrativa (si aplica)
├── docker-compose.yml
├── Dockerfile
├── README.md

Autores
Christian Valverde León. Mario Villarin Vaquerizo Hugo García Ortiz
Proyecto Final de Grado ASIR




