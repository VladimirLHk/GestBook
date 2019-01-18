<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>GuestBook</title>
</head>
<body>
<h2>Гостевая книга</h2>
<?php require_once "show_book.php"?>
<form action="record.php" method="post">
    <h3>Введите заголовок:</h3>
    <input name="TEXT" type="text">
    <h3>Введите текст:</h3>
    <textarea name="TEXTAREA" cols="40" rows="5"></textarea>
    <br>
    <input type="submit" name="Go" value="Отправить">
</form>
</body>
</html>
