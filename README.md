docker-compose up --build
docker-compose exec app php yii fixture/load "User"

CS Fixer
```
docker-compose exec app vendor/bin/php-cs-fixer fix --allow-risky=yes
```