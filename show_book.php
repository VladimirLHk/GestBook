<?php
$delimer = "\t"; //установка разделителя между "Заголовок" и "Сообщение"
$newstr = "##newLine##"; //установка заменителя перевода строки в "Сообщение"
$dataFile = "data.txt"; //установка имени файла с записями гостевой книги
define("EMPTY_BOOK_MSG", "<p>Гостевая книга пока пуста.</p> <p>Ваша запись может быть первой.</p>");

session_start();
$saveOk = isset($_SESSION['saveOk'])?$_SESSION['saveOk']:false;

if (file_exists($dataFile)) {
    $data = file($dataFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

#    $count = 0; //это счетчик числа строк из файла, которые были выведены на экран

    foreach ($data as $str) {
        $content = explode($delimer, $str, 3); //если в строке (вдруг!) оказалась больше одного разделителя
        if (count($content)<3) continue; //если в строке (вдруг!) не оказалось разделителей

        $content[0] = strip_tags(trim($content[0])); //если в тексте даты (вдруг!) были (оказались) лишние пробелы или теги
        $content[1] = htmlspecialchars(trim($content[1])); //если в тексте имени пользователя были (оказались) лишние пробелы или теги
        $content[2] = str_replace($newstr, '<br>', htmlspecialchars(trim($content[2]))); //возвращаем на место переносы строк, которые были в тексте сообщения
        if ($content[0]==="" || $content[1]==="" || $content[2]==="") continue; //если после всего этого какие-то поля оказались пустыми строками
        $page[] = $content;
#        $count++;
    }

    if (count($page)<1) echo EMPTY_BOOK_MSG; //если не была отражена ни одна строка

    else {
        usort($page, function ($a,$b){return strtotime($b[0]) <=> strtotime($a[0]);});
            foreach ($page as $content) {
                ?>
                <div class="note">
                    <p>
                        <span class="date"><?=$content[0]?></span>
                        <span class="name"><?=$content[1]?></span>
                    </p>
                    <p><?=$content[2]?></p>
                </div>
                <?php
            }
        if ($saveOk) { ?>
            <div class="info alert alert-info">
                Запись успешно сохранена!
            </div>
        <?php }
    }

} else echo EMPTY_BOOK_MSG;
?>
