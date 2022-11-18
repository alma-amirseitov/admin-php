# Сервис на php
### Источником текста сообщения должен быть сервис написанный на PHP.

1. Сервис должен иметь страницу с формой, которая должна иметь минимум два элемента:
а. текстовое поле, куда нужно указать текст сообщения
б. кнопка отправить

2. После нажатия кнопки отправить, сервис должен сохранить текст сообщения в любую удобную базу данных для истории.

3. После нажатия кнопки отправить, сервис должен отправить http запрос методом POST в микросервис написанный на GO.

****

### Запуск сервиса.
Введите команду `cd ./public`
Затем запустите сервер с помощью команды `php -S localhost:8080`