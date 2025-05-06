#!/bin/bash

# ACTUALIZAR SISTEMA E INSTALAR DEPENDENCIAS
sudo apt update && sudo apt install -y ca-certificates curl gnupg lsb-release ufw

# INSTALAR DOCKER Y DOCKER COMPOSE
sudo mkdir -p /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin
sudo systemctl enable docker
sudo systemctl start docker

# CREAR PROYECTO
mkdir -p ~/lec_project/pagina-oficial ~/lec_project/panel-control
cd ~/lec_project
echo "<h1>APP Exapolis</h1>" > pagina-oficial/index.html
echo "<h1>ADMIN Exapolis</h1>" > panel-control/index.html

# CREAR DOCKER-COMPOSE
cat > docker-compose.yml <<EOF
services:
  pagina-oficial:
    image: nginx:alpine
    container_name: pagina-oficial
    volumes:
      - ./pagina-oficial:/usr/share/nginx/html:ro
    ports:
      - "8082:80"
    networks:
      - web-net
    restart: unless-stopped

  panel-control:
    image: nginx:alpine
    container_name: panel-control
    volumes:
      - ./panel-control:/usr/share/nginx/html:ro
    ports:
      - "8083:80"
    networks:
      - web-net
    restart: unless-stopped

  postgres:
    image: postgres:15
    container_name: postgres
    environment:
      POSTGRES_USER: admin
      POSTGRES_PASSWORD: secret
      POSTGRES_DB: mydb
    volumes:
      - postgres_data:/var/lib/postgresql/data
    ports:
      - "5432:5432"
    networks:
      - web-net
    restart: unless-stopped

  pgadmin:
    image: dpage/pgadmin4
    container_name: pgadmin
    environment:
      PGADMIN_DEFAULT_EMAIL: admin@tecnozero.com
      PGADMIN_DEFAULT_PASSWORD: Tecnozero1$
    ports:
      - "8081:80"
    networks:
      - web-net
    restart: unless-stopped

  portainer:
    image: portainer/portainer-ce
    container_name: portainer
    ports:
      - "9000:9000"
      - "9443:9443"
    volumes:
      - /var/run/docker.sock:/var/run/docker.sock
      - portainer_data:/data
    restart: unless-stopped

volumes:
  postgres_data:
  portainer_data:

networks:
  web-net:
    driver: bridge
EOF

# LEVANTAR LOS CONTENEDORES
docker compose up -d

# FIREWALL: SOLO PERMITIR ACCESO INTERNO
sudo ufw allow 8081 # pgAdmin
sudo ufw allow 8082 # página oficial
sudo ufw allow 8083 # panel control
sudo ufw allow 5432 # postgres
sudo ufw allow 9000 # portainer
sudo ufw allow 9443
sudo ufw --force enable
sudo ufw reload
