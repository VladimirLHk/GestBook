<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Гостевая книга</title>
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div id="wrapper">
    <h1>Гостевая книга</h1>
    <?php require_once "show_book.php"?>
    <div id="form">
        <form action="record.php" method="POST">
            <p><input name="TEXT" class="form-control" placeholder="Ваше имя"></p>
            <p><textarea name="TEXTAREA" class="form-control" placeholder="Ваш отзыв"></textarea></p>
            <p><input type="submit" name="go" class="btn btn-info btn-block" value="Сохранить"></p>
        </form>
    </div>
</div>
</body>
</html>

