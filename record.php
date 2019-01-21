<?php
$header="
<html>
<head>
<title>from script</title>
<meta content=\'text/html; charset=UTF-8\' http-equiv=Content-Type>
</head>
<body>
";

$delimer = "\t"; //установка разделителя между "Заголовок" и "Сообщение"
$newstr = "##newLine##"; //установка заменителя перевода строки в "Сообщение"
$dataFile = "data.txt"; //установка имени файла с записями гостевой книги
$emptyFieldsMsg="Есть незаполненные поля!";

session_start();
$_SESSION['saveOk']=false;
$a = trim($_POST['TEXT']);
$b = str_replace("\r\n", $newstr, trim($_POST['TEXTAREA']));
if (empty($a) or empty($b)) {
    echo $header;
    echo $emptyFieldsMsg;
    echo "<input type=button value='Вернуться в форму' OnClick='history.back()'>";
    exit;
}

$str = date("d.m.Y H:i:s").$delimer.$a.$delimer.$b."\n";
$f = fopen($dataFile,"at") or die("Что-то пошло не так!!!");
flock($f, LOCK_EX);
if (fwrite ($f, $str)) {
    $startFlush=time();
    while(!fflush($f)) {
        if(time()-$startFlush>10) {
            //тут надо сообщение, что все плохо
            exit ('Отзыв не сохрангился! Повторите, пожалуйста, ввод');
        }
    };
    flock($f, LOCK_UN); //До вресии 5.3.2. можно было не делать, т.к. сразу после этого идет закрытие файла.
    fclose($f);
    $_SESSION['saveOk']=true;
    header("Location: ".$_SERVER['HTTP_REFERER']);
} else {
    echo $header;
    exit ("Ошибка при работе с data.txt");
}

