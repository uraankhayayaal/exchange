composer install

php init --env=Development --overwrite=All
php yii migrate --interactive=0
php-fpm