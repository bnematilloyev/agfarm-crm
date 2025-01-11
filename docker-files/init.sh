# installs composer dependencies for api project
docker-compose exec drugs-app composer install

# installs composer dependencies for adminapi project
docker-compose exec drugs-app test ! -f /var/www/app/frontend/web/index.php && ./init

# replace database configurations to connect docker database
docker-compose exec drugs-app cp /var/www/app/docker-files/yii-files/main-local.php /var/www/app/common/config

# restoring database with existing SQL files
docker-compose exec drugs-db bash /var/mysql-dumps/restore-database.sh