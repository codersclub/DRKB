---
Title: Простейший CGI на Дельфи
Author: Vit
Date: 01.01.2007
---


Простейший CGI на Дельфи
========================

::: {.date}
01.01.2007
:::

    program helloworld;
     

     
     
    {$E cgi}
    begin
      Write('Content type: Text/HTML' + #13#10#13#10);
      Write('Hello World!');
    end.

Всё что этот код делает это выводит в поток вывода \'Hello World!\'.
Открываем новый проэкт. Удаляем все из DPR файла, заполняем приведенным
кодом. Компиллируем. Полученный файл helloworld.cgi ставим в папку
cgi-bin IIS сервера, убеждаемся что в настройках сервера разрешено
исполнение серверных скриптов и сам сервер включен, далее открываем
браузер и вводим адрес, у меня это:

httр://vitaly/cgi-bin/helloworld.cgi

любуемся надписью \"Hello World!\" в браузере.

А вот чуть более сложный пример - вывод потока (в данном случае если
поток содержит картинку) в браузер:

    procedure OutputStream(m: TStream);
     

     
     
    var h: Integer;
      j: cardinal;
    begin
      h := GetStdHandle(STD_OUTPUT_HANDLE);
      try
        WriteFile(h, 'Content type: image/x-MS-bmp' + #13#10#13#10, 32, j, nil);
        WriteFile(h, m.memory^, m.size, j, nil);
      finally
        CloseHandle(h);
      end;
    end;

Теперь сделанный cgi можно использовать в качестве картинки.

Естественно, что работать такой CGI ,будет только в среде Windows (для
работы под Linux надо подумать над компилляцией в среде Kilix)

Ещё типы контента:

text/html

text/plain

text/richtext

image/gif

image/jpeg

image/x-MS-bmp

image/x-xpixmap

video/mpeg

video/quicktime

audio/x-wav

audio/basic (Sun *.au audio files)

audio/mp3

audio/mpeg

audio/x-mp3

audio/x-mpeg

audio/m3u

audio/x-m3u

audio/x-aiff (aif aiff aifc)

application/msword

application/octet-stream (для exe)

application/x-zip

application/mac-binhex40 (hqx)

application/pdf

application/rtf

application/x-latex

application/zip

application/rss+xml

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
