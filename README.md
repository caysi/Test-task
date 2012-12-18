Test-task
=========

Дамп базы находится в dump/dump.sql
И необходимо настроить config
Нужно переименовать фаил inc/configs/config.php.tpl
и прописать константы для подключения к базе 
mv inc/configs/config.php.tpl inc/configs/config.php
Пример содержимого:
define("DB_HOST", 'localhost');
define("DB_USER", 'root');
define("DB_PASS", 'password');
define("DB_NAME", 'testTask');
