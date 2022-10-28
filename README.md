### Запуск проекта

```php
cp .env.test .env
docker-compose up --build -d
cd app
cp .env.test .env
```
Развернутые контейнеры
```php
docker ps
```
Composer, console доступны в php-cli, войти в контейнер:
```php
docker exec -it <container php-cli id> bash
```
Некоторые осознанные недоработки: нет валидации (где есть, не верная, через генерацию exception), нет resources и json ответы не полные, синхронное выполнение генерации отчетов нет очередей и задач. <br>
### Эндпоинты
- #### http://localhost:8081/products/?order_field=<price/title>&order=<DESC/ASC> GET (Товары с сортировкой и пагинацией)
Пример ответа: <br>
`{
{"result":[{"id":1,"title":"testname","price":123},{"id":2,"title":"testname","price":123},{"id":3,"title":"testname","price":123}],"numResult":10,"currentPage":1,"lastPage":4,"pageSize":3,"previousPage":1,"nextPage":2,"toPaginate":true}
}`
- #### http://localhost:8081/order/new/ POST (Создание заказа)
Пример запроса:<br>
`
{
"products":[
{
"id":6,
"count":3
},
{
"id":1,
"count":6
}]
}
`<br>
Пример ответа: <br>
`{
{"approvedAt":null,"id":21,"Products":[{"id":6,"count":3,"price_unit":1000},{"id":1,"count":6,"price_unit":123}],"approved":false,"price":3738,"totalCount":9}
}`<br>
- #### http://localhost:8081/order/edit/ PATCH (Редактирование заказа)
Пример запроса:<br>
`{
"id":21,
"products":[
{
"id":3,
"count":5
}
]
}`
Пример ответа: <br>
` {
"approvedAt": null,
"id": 21,
"Products": [
{
"id": 3,
"count": 5,
"price_unit": 123
}
],
"approved": false,
"price": 615,
"totalCount": 5
}`
- #### http://localhost:8081/order/{id}/approve/ GET (Подтверждение заказа)
Пример запроса: <br>
`
http://localhost:8081/order/21/approve/
`<br>
Пример ответа: <br>
`{
{
"approvedAt": "2022-10-27T10:31:11+00:00",
"id": 21,
"Products": [
{
"id": 3,
"count": 5,
"price_unit": 123
}
],
"approved": true,
"price": 615,
"totalCount": 5
}
}`
- #### http://localhost:8081/report/daily/create
- #### http://localhost:8081/report/weekly/create
- #### http://localhost:8081/report/monthly/create  GET (Создание отчетов)<br>
Пример ответа: <br>
`
"Success created"
`
- #### http://localhost:8081/report/daily/?order_field=<total_price/total_count>&order=<DESC/ASC>
- #### http://localhost:8081/report/weekly/?order_field=<total_price/total_count>&order=<DESC/ASC>
- #### http://localhost:8081/report/monthly/?order_field=<total_price/total_count>&order=<DESC/ASC> GET (Получение отчетов, Топ продаж по количеству/деньгам - через сортировку)<br>
Пример ответа: <br>
(orders - заказы в единицу периода,title - время начала/конца единицы периода, totalCount - общее число проданных едениц за единицу периода, totalPrice - общая стоимость за единицу периода, proceed - совокупная выручка за отчет)<br>
`
{"0":{"id":1,"orders":[{"approvedAt":"2022-10-20T08:18:14+00:00","id":17,"Products":[{"id":6,"count":31,"price_unit":123}],"approved":true,"price":3813,"totalCount":31},{"approvedAt":"2022-10-20T09:18:14+00:00","id":16,"Products":[{"id":6,"count":300,"price_unit":123}],"approved":true,"price":36900,"totalCount":300}],"title":"2022-10-20 00:00:00 - 2022-10-21 00:00:00","totalCount":331,"totalPrice":40713},"1":{"id":2,"orders":[{"approvedAt":"2022-10-28T09:18:14+00:00","id":15,"Products":[{"id":6,"count":300,"price_unit":123}],"approved":true,"price":36900,"totalCount":300}],"title":"2022-10-28 00:00:00 - 2022-10-29 00:00:00","totalCount":300,"totalPrice":36900},"2":{"id":3,"orders":[{"approvedAt":"2022-11-26T09:18:14+00:00","id":12,"Products":[{"id":6,"count":30,"price_unit":123}],"approved":true,"price":3690,"totalCount":30}],"title":"2022-11-26 00:00:00 - 2022-11-27 00:00:00","totalCount":30,"totalPrice":3690},"3":{"id":4,"orders":[{"approvedAt":"2022-11-27T09:18:14+00:00","id":13,"Products":[{"id":6,"count":36,"price_unit":123}],"approved":true,"price":4428,"totalCount":36}],"title":"2022-11-27 00:00:00 - 2022-11-28 00:00:00","totalCount":36,"totalPrice":4428},"4":{"id":5,"orders":[{"approvedAt":"2022-11-28T09:18:14+00:00","id":14,"Products":[{"id":6,"count":300,"price_unit":123}],"approved":true,"price":36900,"totalCount":300}],"title":"2022-11-28 00:00:00 - 2022-11-29 00:00:00","totalCount":300,"totalPrice":36900},"5":{"id":6,"orders":[{"approvedAt":"2022-12-26T09:16:14+00:00","id":10,"Products":[{"id":6,"count":30,"price_unit":123},{"id":5,"count":10,"price_unit":123}],"approved":true,"price":4920,"totalCount":40},{"approvedAt":"2022-12-26T09:18:14+00:00","id":11,"Products":[{"id":6,"count":30,"price_unit":123},{"id":5,"count":120,"price_unit":123}],"approved":true,"price":18450,"totalCount":150}],"title":"2022-12-26 00:00:00 - 2022-12-27 00:00:00","totalCount":190,"totalPrice":23370},"proceed":"146001"}
}`
