# Задание

Нужно реализовать простое REST API которое позволяет сделать следующие вещи:
 - добавить пользователя в друзья (отправить запрос)
 - просмотреть список запросов на добавление в друзья
 - подтвердить запрос на добавление в друзья
 - отклонить запрос на добавления в друзья
 - просмотреть список своих друзей
 - просмотреть список всех друзей своих друзей

Выбор технологий - фреймворков, библиотек, БД  и т.п. за тобой.
Использование TDD приветствуется. Ограничение по БД - можно использовать любую NoSQL БД

### Users
GET user/

GET user/{id}

POST user/add
```json
{"name": "Test", "description": "test"}
```

### Friendship
add friendship

POST friendship/{id}?userId={currentUser}

confirm friendship

PUT friendships/{id}?userId={currentUser}

delete friendship

DELETE friendships/{id}?userId={currentUser}

### Friends
GET friends/

GET friends/{depth}

