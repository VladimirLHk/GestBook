<?php
/**
 * Created by PhpStorm.
 * User: VLKhomutov
 * Date: 17.01.2019
 * Time: 22:02
 */
$header="
<html>
<head>
<title>from script</title>
<meta content=\'text/html; charset=UTF-8\' http-equiv=Content-Type>
</head>
<body>
";

if (empty($GLOBALS['delimer'])) $GLOBALS['delimer']="\t";
$delimer = $GLOBALS['delimer']; //установка разделителя между "Заголовок" и "Сообщение"
if (empty($GLOBALS['newstr'])) $GLOBALS['newstr']="##newLine##";
$newstr = $GLOBALS['newstr']; //установка заменителя перевода строки в "Сообщение"
if (empty($GLOBALS['dataFile'])) $GLOBALS['dataFile']="data.txt";
$dataFile = $GLOBALS['dataFile']; //установка имени файла с записями гостевой книги


$emptyFieldsMsg="Есть незаполненные поля!";
$a = trim($_POST['TEXT']);
$b = str_replace("\r\n", $newstr, trim($_POST['TEXTAREA']));
if (empty($a) or empty($b)) {
    echo $header;
    echo $emptyFieldsMsg;
    echo "<input type=button value='Вернуться в форму' OnClick='history.back()'>";
    exit;
}

$str = $a.$delimer.$b."\n";
$f = fopen($dataFile,"at") or die("Что-то пошло не так!!!");
flock($f, LOCK_EX);
if (fwrite ($f, $str)) {
    flock($f, LOCK_UN);
    fclose($f);
    header("Location: ".$_SERVER['HTTP_REFERER']);
    /*
    А вот другой способ:
    echo "<HTML><HEAD><META HTTP-EQUIV = 'Refresh' CONTENT='3;URL=index.html'></HEAD></HTML>";
    */
} else {
    echo $header;
    exit ("Ошибка при работе с data.txt");
}

