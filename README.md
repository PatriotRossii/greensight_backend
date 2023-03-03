# Тестовое задание для направления «backend разработка»

## Требования

1. Создать страницу с формой, в которой должны быть следующие поля: имя, фамилия, email, пароль, повтор пароля
2. Реализовать отправку этой формы при помощи AJAX
3. Реализовать обработку AJAX запроса на php, в обработчике необходимо:
	1. Провести валидацию, что email содержит @ и пароли совпадают; при желании эти валидации можно также продублировать еще на клиенте (js)
	2. Задать некий массив уже существующих пользователей (получать его из какой-либо базы данных не требуется). В массиве должны присутствовать поля email, id, name
	3. Провести проверку есть ли в этом массиве элемент с заполненным пользователем емейлом.
	4. Результат проверки должен логироваться в файл в любом формате
    5. При успешной проверке - форма должна скрываться, а пользователю должно выводиться сообщение об успешной регистрации.
    При неудачной проверке - пользователю должна выводиться ошибка над формой.
4. Создать публичный репозиторий на github и загрузить туда весь исходный код задания. Файлы-логи не должны попадать в репозиторий.
В качестве результата передать ссылку на этот репозиторий.

Можно использовать любые javascript библиотеки.
Для стилизации страницы использовать [getbootstrap.com](https://getbootstrap.com/)

## Инструкция по запуску

Развертывание сервера производится с помощью команды

```
sudo docker-compose up -d
```

После нее веб-сайт будет доступен по адресу http://127.0.0.1:80 (предварительно убедитесь, что порт 80 свободен)

Логи сохранются в локальной директории `logs/`