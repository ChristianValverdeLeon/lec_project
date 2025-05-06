#!/bin/bash

echo "==> [SERVIDOR] Parando y eliminando el contenedor File Browser (si existe)..."
docker rm -f filebrowser 2>/dev/null

echo "==> [SERVIDOR] Eliminando carpeta de configuración y volúmenes de File Browser..."
rm -rf /home/ubuntu/lec_project/server/filebrowser

echo "==> [SERVIDOR] Eliminando imagen local (si existe)..."
docker images | grep filebrowser && docker rmi filebrowser/filebrowser -f || echo "Imagen ya eliminada."

echo "==> [SERVIDOR] Limpieza de File Browser completada."
