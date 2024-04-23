url de swagger ui: http://localhost/api-test/api/documentation/

url que descarga las anotaciones: http://localhost/api-test/api/post/posts.php

abrir xampp, activar apache y MySql

crear en phpmyadmin una base de datos "test" que contenga category y posts
category: int id, var name
posts: int id, var title, int category_id, var description
crea algunos para ir probando, o usando las funciones en postman o swagger.

GET: http://localhost/api-test/api/post/posts.php
GET: http://localhost/api-test/api/post/single.php?id=3
POST: http://localhost/api-test/api/post/insert.php
PUT: http://localhost/api-test/api/post/update.php
DELETE: http://localhost/api-test/api/post/destroy.php?id=9


https://www.youtube.com/watch?v=q_eLPG4PDM8&list=PLi07GF6GSS3qyYOM-jqeSg4IbG_Z8l5Xy&index=100