### Clone repository
git clone https://github.com/andrecausingg/laravel-todo-board.git

### Change path
cd laravel-todo-board

### Copy .env.example to .env
cp .env.example .env

### Start Docker containers
docker-compose up -d

### Install PHP dependencies
docker exec -it board-todo-api composer install

### Run database migrations
docker exec -it board-todo-api php artisan migrate

### Clear config, cache, compiled, events, routes, views
docker exec -it board-todo-api php artisan optimize:clear

### Generate Laravel app key
docker exec -it board-todo-api php artisan key:generate

### Generate JWT secret key
docker exec -it board-todo-api php artisan jwt:secret

### App name | Update variable in .env
APP_NAME=todoBoard

### Database Host | Update variable in .env
DB_HOST=board-todo-mysql
### Database Password | Update variable in .env
DB_PASSWORD=passBoardTodo

### Database | Update variable in .env
DB_FORWARD_PORT=3307

### Cors allowed origin | Add variable in .env
CORS_ALLOWED_ORIGINS=http://localhost:5173
### Cors allowed origin patterns | Add variable in .env
CORS_ALLOWED_ORIGINS_PATTERNS=/^http:\/\/localhost:\d+$/

### Code paths | Add variable in .env
APP_CODE_PATH=.
### Code paths file | Add variable in .env
APP_FILES_PATH=./storage_files

### Port api | Add variable in .env
APP_PORT=8001 

### PhpMyAdmin Port | Add variable in .env
PMA_PORT=8000
