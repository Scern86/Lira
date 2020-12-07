# Lira
Небольшая и лёгкая платформа на PHP.

# Возможности:
- Авторизация пользователей и назначение прав доступа к ресурсам, а также выполнения действий с ними;
- Создание ресурсов: 
  --готовые типы: статья,фотоальбом,изображение,документ,модуль,пункт меню,пользователь,фрейм,запрос);
  --собственные типы, произвольный набор полей с иерархической вложенностью ресурсов;
- Не требуется изменение структуры базы данных или кода ядра, описывается лишь шаблон отображения ресурса (и,возможно,какая то логика обработки содержимого);
- Поддержка мультиязычности интерфейса;


# Требования
PHP версии 7.1 или выше.
MySQL.
Apache+NGINX.

# Установка
Установщика нет.


# Документация
Скоро тут появится ссылка.


# Структура базы данных
```Содержимое:
- Таблица _object (список всех объектов/ресурсов):
 -- id      | varchar | 50 | PrimaryKey
 -- title   | varchar | 500
 -- created | datetime

- Таблица _tag (список всех тегов/меток объектов):
 -- id    | varchar | 50 | PrimaryKey
 -- title | varchar | 255

- Таблица _definition (список всех определений полей объектов):
 -- title       | varchar | 50 | PrimaryKey
 -- type        | varchar | 20
 -- description | varchar | 255

- Таблица _field_date (поля Date объектов)
 -- id_object  | varchar | 50 | PrimaryKey
 -- definition | varchar | 50
 -- field      | datetime
 
- Таблица _field_long_text (Текстовые поля Mediumtext объектов)
 -- id_object  | varchar | 50 | PrimaryKey
 -- definition | varchar | 50
 -- field      | mediumtext
 
 - Таблица _field_short_text (Текстовые поля Text объектов)
 -- id_object  | varchar | 50 | PrimaryKey
 -- definition | varchar | 50
 -- field      | text

- Таблица _field_number (Числовые поля объектов)
 -- id_object  | varchar | 50 | PrimaryKey
 -- definition | varchar | 50
 -- field      | int | 11
 
 - Таблица _field_object (Поля для вложенных объектов)
 -- id_object_parent | varchar | 50 | PrimaryKey
 -- id_object_child  | varchar | 50 | PrimaryKey
 -- definition       | varchar | 50
 -- order            | int | 11
 -- params           | varchar | 255

- Таблица _field_string (Строковые поля объектов)
 -- id_object  | varchar | 50 | PrimaryKey
 -- definition | varchar | 50
 -- field      | varchar | 500
 
 - Таблица _field_tag (Поля для меток объектов)
 -- id_object  | varchar | 50 | PrimaryKey
 -- definition | varchar | 50 | PrimaryKey
 -- id_tag     | varchar | 50 | PrimaryKey
 -- order      | tinyint | 4
 
Доп.таблицы:
 - Таблица _login (Лог авторизаций пользователей)
 -- id         | int      | 11 | PrimaryKey
 -- id_user    | varchar  | 50
 -- logged_in  | datetime
 -- ssid       | varchar  | 50
 -- ip_address | varchar  | 50

 - Таблица _log_actions (Лог действий авторизованных пользователей)
 -- id        | int      | 11 | PrimaryKey
 -- id_user   | varchar  | 50
 -- component | varchar  | 50
 -- task      | varchar  | 50
 -- id_object | varchar  | 50
 -- created   | DATETIME
 -- success   | tynyint  | 1
 ```
# Структура каталогов
```
/classes
/components/
/core/
/language/
/media/
/modules/
/templates/
```
# Лицензия
Платформа Lira распространяется под лицензией под лицензией [MIT](LICENSE).
