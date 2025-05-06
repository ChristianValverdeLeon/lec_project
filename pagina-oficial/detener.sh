#!/bin/bash

echo ">>> Deteniendo y eliminando contenedores Docker..."
docker stop $(docker ps -aq) 2>/dev/null
docker rm -f $(docker ps -aq) 2>/dev/null

echo ">>> Eliminando volúmenes Docker..."
docker volume rm $(docker volume ls -q) 2>/dev/null

echo ">>> Eliminando redes personalizadas..."
docker network prune -f

echo ">>> Borrando proyecto ~/lec_project..."
sudo rm -rf ~/lec_project

echo ">>> Liberando puerto 5432 si está ocupado por servicio externo..."
sudo systemctl stop postgresql 2>/dev/null
sudo systemctl disable postgresql 2>/dev/null
sudo apt purge -y postgresql* 2>/dev/null
sudo apt autoremove -y

echo ">>> Limpieza completada. El servidor está listo para reconfigurarse."
