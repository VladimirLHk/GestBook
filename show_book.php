<?php
if (empty($GLOBALS['delimer'])) $GLOBALS['delimer']="\t";
$delimer = $GLOBALS['delimer']; //установка разделителя между "Заголовок" и "Сообщение"
if (empty($GLOBALS['newstr'])) $GLOBALS['newstr']="##newLine##";
$newstr = $GLOBALS['newstr']; //установка заменителя перевода строки в "Сообщение"
if (empty($GLOBALS['dataFile'])) $GLOBALS['dataFile']="data.txt";
$dataFile = $GLOBALS['dataFile']; //установка имени файла с записями гостевой книги


define("EMPTY_BOOK_MSG", "<p>Гостевая книга пока пуста.</p> <p>Ваша запись может быть первой.</p>");

if (file_exists($dataFile)) {
    $data = file($dataFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    echo "<table>";
    echo "<tr><th>Заголовок</th><th>Сообщение</th></tr>";

    $count = 0; //это счетчик строк из файла, которые были выведены на экран

    foreach ($data as $str) {
        $content = explode($delimer, $str, 2); //если в строке (вдруг!) оказалась больше одного разделителя
        if (!$content) continue; //если в строке (вдруг!) не оказалось разделителей

        $content[0] = htmlspecialchars(trim($content[0])); //если в тексте заголовка были (оказались) лишние пробелы или теги
        $content[1] = str_replace($newstr, '<br>', htmlspecialchars(trim($content[1]))); //возвращаем на место переносы строк, которые были в тексте сообщения
        if($content[0]==="" || $content[1]==="") continue; //если после всего этого "Заголовок" или "Сообщение" оказались пустыми строками

        echo "<tr><td>$content[0]</td><td>$content[1]</td></tr>";
        $count++;
    }

    echo "</table>";
    if (!$count) echo EMPTY_BOOK_MSG; //если не была отражена ни одна строка

} else echo EMPTY_BOOK_MSG;

