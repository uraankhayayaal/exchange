# Первая задача
```sql
SELECT
    CONCAT(u.first_name, ' ', u.last_name) AS Name,
    b.author as Author,
    GROUP_CONCAT(b.name SEPARATOR ', ') AS Books
FROM
	user_books ub
INNER JOIN users u ON ub.user_id = u.id
INNER JOIN books b ON ub.book_id = b.id
WHERE
    u.birthday + INTERVAL 7 YEAR <= NOW()
    AND u.birthday + INTERVAL 17 YEAR >= NOW()
    AND DATEDIFF(ub.return_date, ub.get_date) <= 14
GROUP BY
	CONCAT(u.first_name, ' ', u.last_name),
    b.author
HAVING
	COUNT(b.name) = 2
```

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