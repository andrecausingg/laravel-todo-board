# Todo Board API

A robust, containerized Todo Management API built with **Laravel 12**, featuring **JWT Authentication** and a fully **Dockerized**

# Tech Stack
* **Backend:** Laravel 12.55.1 (PHP 8.2)  
* **Database:** MySQL 9.6.0
* **Auth:** JWT (JSON Web Tokens)  
* **Web Server:** Nginx (Alpine)  
* **Tools:** Docker Desktop, phpMyAdmin  

# Clone repository and setup .env
git clone https://github.com/andrecausingg/laravel-todo-board.git

# Change path
cd laravel-todo-board

# Copy .env.example to .env
cp .env.example .env

# Start Docker containers
docker-compose up -d

# Install PHP dependencies
docker exec -it board-todo-api composer install

# Run database migrations
docker exec -it board-todo-api php artisan migrate

# Clear config, cache, compiled, events, routes, views
docker exec -it board-todo-api php artisan optimize:clear

# Generate Laravel app key
docker exec -it board-todo-api php artisan key:generate

# Generate JWT secret key
docker exec -it board-todo-api php artisan jwt:secret

# App | update variable
APP_NAME=todoBoard

# Database | update variable
DB_HOST=board-todo-mysql
DB_PASSWORD=passBoardTodo

# Database | update variable
DB_FORWARD_PORT=3307

# Cors origin | add variable
CORS_ALLOWED_ORIGINS=http://localhost:5173
CORS_ALLOWED_ORIGINS_PATTERNS=/^http:\/\/localhost:\d+$/

# Paths | add variable
APP_CODE_PATH=.
APP_FILES_PATH=./storage_files

# Port api | add variable
APP_PORT=8001 

# Port php | my admin add variable
PMA_PORT=8000
