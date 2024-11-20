# Установка и запуск

To run and build app use:
```
docker-compose up --build
```

To create default user (Нужен чтобы не подтвержадть электронную почту):
```
docker-compose exec app php yii fixture/load "User"
```

Запустить в браузере проект: [http://localhost/](http://localhost/)
1. Нужно авторизаоваться с теми данными которые в примере для каждого запроса из swagger
1. Авторизаовать swagger с помощью полученного токена
1. Сделать запросы по exchange

# Комментраий
1. Формат url сделал немного иначе
1. БД не стал сохранять курсы, они постоянно меняются
1. Формат выходных данных для метода convert оставил строковым, тк точность пропадала

# Дополнительные команды
CS Fixer
```
docker-compose exec app vendor/bin/php-cs-fixer fix --allow-risky=yes
```

Analize PHP stan
```
docker-compose exec app vendor/bin/phpstan analyse -c phpstan.neon
```