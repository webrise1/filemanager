Расширение для yii2 filemanager
==========================
Расширение для yii2 filemanager

1.Установка
------------

Устанавливаем через [composer](http://getcomposer.org/download/).


```
composer require webrise1/filemanager
```
 

2.Выполняем миграции
-----
```
yii migrate --migrationPath=@webrise1/filemanager/migrations --interactive=0
```
3.Настраиваем конфигурацию
-----

В файле `config/web.php` (yii2 Basic) подключаем расширение
```php
        'modules' => [
             'filemanager' => [
                       'class' => 'webrise1\filemanager\Module',
                       'layout'=>'@app/modules/admin/views/layouts/main',
                       'uploadsDir'=>'uploads'
           
                   ],
         ]
```

#### Параметры
 
>**uploads** - путь к директории для сохранения файлов `(Обязательный параметр)`
 
>**layout** - путь к шаблону админки


4.Методы
-----
>4.1.  Замена сниппета данными
```php
 Пример:
 $data="<img src='[[file_21]]'/>";
 $data=\webrise1\filemanager\models\File::convertFileSnippets($data);
 echo $data; 
 
 Результат:  <img src='/filemanager/get-file?code=x3oi3eT9SSbLQWZ-A0JQ0wc2R6lcub9x'/> 
 ```
 
5.Список методов api
-----

>5.1.  Получение рейтинга участников 
`/mentor/api/ajax/get-users-rate` 

>5.2  Получение общего бала
`/mentor/api/ajax/get-total-points-by-session` 

>5.3  Получение навыков пользователя
`/mentor/api/ajax/get-user-skills` 

>5.4  Получение командного рейтинга
`/mentor/api/ajax/get-teams-rate` 

>5.5  Проверка выполнил ли пользователь уже задание
`/mentor/api/ajax/check-task-questionnaire?taskId=id` 

>5.6  Сохранение анкеты пользователя (POST)
`/mentor/api/ajax/set-competition-questionnaire` 

>5.7  Сохранение формы задания  
>`/mentor/api/ajax/save-task-questionnaire` 
> (POST)
```php
 taskId:taskId
 inputName:name
 inputName1:name1
 inputNameFile: { 1:{data:base64data,ext:ext},2:{data:base64data,ext:ext} }
 inputNameFile1:{ 1:{data:base64data,ext:ext},2:{data:base64data,ext:ext} }
 ```
 >5.8  Получение данных по заданию (POST)
 >`/mentor/api/ajax/get-task-questionnare` 
 
 > Чтобы получить данные во фронт необходимо в админке установить уровень доступа "Общедоступный" нужным полям задания
 ```php
 taskId:taskId
 needParams:fio,project_name
 filterParams[fio]='Алекс' 
 
  ```