#!/bin/bash

# VARIABLES
DIR_BASE="/home/ubuntu/lec_project/server"
NOMBRE_CONTENEDOR="filebrowser"
PUERTO_NUEVO=8085

echo ">> Deteniendo y eliminando contenedor anterior de File Browser..."
docker stop $NOMBRE_CONTENEDOR 2>/dev/null
docker rm $NOMBRE_CONTENEDOR 2>/dev/null

echo ">> Abriendo puerto $PUERTO_NUEVO en UFW..."
ufw allow $PUERTO_NUEVO/tcp

echo ">> Ejecutando nuevo contenedor File Browser en el puerto $PUERTO_NUEVO..."
docker run -d \
  --name $NOMBRE_CONTENEDOR \
  -v $DIR_BASE/pagina-oficial:/srv/pagina-oficial \
  -v $DIR_BASE/panel-control:/srv/panel-control \
  -v /home/ubuntu/filebrowser/config:/config \
  -p $PUERTO_NUEVO:80 \
  filebrowser/filebrowser:s6

echo ">> File Browser está disponible en http://192.168.26.100:$PUERTO_NUEVO"
