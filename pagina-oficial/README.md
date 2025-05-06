_**Proyecto Final de Grado**_

Este documento describe la configuración completa de la máquina que actúa como servidor principal dentro de una infraestructura distribuida basada en Docker, NGINX y PostgreSQL. Esta instalación forma parte de un sistema escalable en el que se utiliza un proxy inverso en una máquina externa para redirigir tráfico a distintos servicios alojados en esta instancia.

**Información general**

La máquina servidor se encuentra en la dirección IP privada 192.168.26.100. En ella se han desplegado cuatro servicios principales:

- Página oficial del proyecto
- Panel de administración
- Base de datos PostgreSQL
- Interfaz de gestión visual de contenedores mediante Portainer


Todos los servicios funcionan en contenedores independientes, utilizando puertos internos diferentes para evitar conflictos. El acceso externo se realiza a través de un proxy inverso (ubicado en otra máquina), lo que permite mantener una estructura organizada y escalable.

**Requisitos previos**
- Ubuntu 22.04 o superior
- Permisos de superusuario
- Conexión a internet

Acceso al puerto 8080 (permitido por el firewall para servicios web)

**Estructura del proyecto**

El proyecto está organizado en un único directorio llamado lec_project, que contiene:

Carpetas con el contenido HTML de cada sitio

Scripts automatizados para la instalación y despliegue de contenedores

Archivo docker-compose.yml generado automáticamente por el script principal


**Servicios desplegados y puertos**

- PostgreSQL: puerto interno 5432, expuesto en el 15432

- pgAdmin: puerto interno 80, expuesto en el 8080

- Página oficial: puerto interno 80, expuesto en el 8081

- Panel de control: puerto interno 80, expuesto en el 8082

- Portainer: puerto 9000 para interfaz web de administración de contenedores


Cada servicio es accesible de forma local mediante su puerto, pero externamente se accede por nombre de dominio a través del proxy.

**_Pulls con las imagenes de docker_**
SERVIDOR
- docker pull christian15685685678/postgres:15
- docker pull christian15685685678/pgadmin4:latest
- docker pull christian15685685678/nginx:panel
- docker pull christian15685685678/nginx:pagina
PROXY
- docker pull christian15685685678/nginx:proxy

**_Despliegue_**

1. Clonar el repositorio del proyecto
2. Asignar permisos de ejecución al script principal
3. Ejecutar el script servidor.sh, el cual:

Instala Docker y Docker Compose (si no están instalados)

Crea la red Docker web-net

Genera archivos de prueba en las carpetas web

Crea un archivo docker-compose.yml personalizado

Lanza todos los contenedores necesarios

**Scripts incluidos**

servidor.sh: despliegue automatizado completo

detener.sh: detiene y elimina todos los contenedores y recursos del proyecto

mover.sh: organiza y estructura el proyecto en carpetas internas (opcional)


**Acceso a servicios desde red local**

pgAdmin: http://192.168.26.100:8080

Página oficial: http://192.168.26.100:8081

Panel de control: http://192.168.26.100:8082

Portainer: http://192.168.26.100:9000


Una vez configurado el proxy inverso, los servicios serán accesibles desde internet utilizando:

http://app.exapolis.com

http://admin.exapolis.com

**Próximos pasos**

Una vez desplegado el servidor, se debe proceder a configurar la segunda máquina que actúa como proxy inverso. Esta máquina, con IP 192.168.26.50, recibirá el tráfico entrante y lo distribuirá hacia los servicios apropiados del servidor según el dominio.

**Autores**
Christian Valverde León Mario Villarin Vaquerizo Hugo García Ortiz
Trabajo de Fin de Grado - Proyecto de Infraestructura Web
Repositorio oficial: https://github.com/ChristianValverdeLeon/lec_project
