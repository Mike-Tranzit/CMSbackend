Запустил тестовую платформу у себя на сервере по адресу http://potok.littlemonster.ru/

Аккредитация водителей, автомобилей, прицепов.

**Аутентификация:**

POST http://potok.littlemonster.ru/v1/site/create?expand=users

Тело запроса:
1. пользователь:

`{
	"username":"+79183333333",
	"password":"zaq12wsx"
}`

2. пользователь:

`{
	"username":"+79283333333",
	"password":"zaq12wsx"
}`

3. пользователь:

`{
	"username":"+70283333333",
	"password":"zaq12wsx"
}`

**Получение списка автомобилей текущего пользователя:**

GET http://potok.littlemonster.ru/v1/truck

**Получение данных о конкретном автомобиле:**

GET http://potok.littlemonster.ru/v1/truck/1

**Получение статуса аккредитации конкретного водителя конкретного пользователя:**

GET http://potok.littlemonster.ru/v1/truck/1?fields=confirm

**Создание нового автомобиля:**

POST http://potok.littlemonster.ru/v1/truck

`{
    "plate": "а612ву23",
    "brand": "ВАЗ",
    "tonnage": "400",
    "trailer_type": "2",
    "vehicle_certificate": "а23аа22222",
    "identification_document": "1",
    "document_number": "2315000000"
}`

**Редактирование автомобиля:**

PUT http://potok.littlemonster.ru/v1/truck/1

или

PATCH http://potok.littlemonster.ru/v1/truck

{
    "plate": "а612ву123"
}

**Удаление автомобиля:**

DELETE http://potok.littlemonster.ru/v1/truck/1

Получаем id пользователя Yii::$app->user->id 

Полчаем роль пользователя Yii::$app->user->identity->role
