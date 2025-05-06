#!/bin/bash

echo "==> Creando carpeta de proyecto organizada..."
mkdir -p /home/ubuntu/lec_project/server

echo "==> Moviendo archivos de configuración y carpetas..."
mv -v /home/ubuntu/docker-compose.yml /home/ubuntu/lec_project/server/ 2>/dev/null
mv -v /home/ubuntu/pagina-oficial /home/ubuntu/lec_project/server/ 2>/dev/null
mv -v /home/ubuntu/panel-control /home/ubuntu/lec_project/server/ 2>/dev/null
mv -v /home/ubuntu/*.sh /home/ubuntu/lec_project/server/ 2>/dev/null

echo "==> Movimiento completado."

echo "==> Verificando contenedores activos (no se tocan)..."
docker ps

echo -e "\n>>> Listo. Tus archivos ahora están en: /home/ubuntu/lec_project/server"
echo ">>> Puedes hacer git init y subir a GitHub desde ahí sin miedo."
