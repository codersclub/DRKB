---
Title: Вывод изображений
Author: Paul TOTH
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Вывод изображений
=================

**Заголовок HTTP-ответа для HTML-страниц**

Мы уже знаем, что для сообщения браузеру, что передаваемый документ
является HTML-документом, CGI-программа выводит специальный заголовок,
не отображаемый браузером:

    WriteLn('Content-Type: text/html');
    WriteLn('');

**HTTP-заголовок для изображений**

Точно таким же образом можно с успехом указать и другой тип данных!
Например, для вывода изображения в формате GIF достаточно вывести
следующее:

    WriteLn('Content-Type: image/gif');
    WriteLn('');

Таким образом мы сообщаем браузеру, что далее будет следовать именно
изображение...

**Передача двоичных данных**

Для начала давайте разберемся, как отправить двоичные данные в
STDOUTPUT.

Я написал две процедуры: первая выводит поток TSTREAM в STDOUTPUT, а
вторая выводит двоичный файл в выходной поток:

    // Процедура вывода потока в STDOUTPUT.
    // Попробуйте самостоятельно переделать ее для Kylix...
    procedure WriteStream(stream:TStream);
     var
      OutStream:THandleStream;
    begin
     Flush(output); // для передачи заголовка мы используем обычный WRITELN...
     // здесь используется код из программы
     // DCOUNTER for Delphi 3 by Dave Wedwick (dwedwick@bigfoot.com)
     OutputStream:=THandleStream.Create(GetStdHandle(STD_OUTPUT_HANDLE));
     Stream.SaveToStream(OutputStream);
     OutputStream.Free;
    end;
    
    // Процедура для передачи двоичного файла
    procedure WriteFile(FileName:string);
     var
      s:TFileStream;
    begin
     s:=TFileStream.Create(FileName,fmOpenRead);
     WriteStream(s);
    end;

**Передача GIF файлов**

Теперь нам осталось только создать (или взять готовый) GIF файл и
вывести его!

    procedure WriteGIF(FileName:string);
    begin
      WriteLn('Content-type: image/gif');
      WriteLn;
      WriteFile(FileName);
    end;

Кстати! Долой файлы типа GIF!  

[![Burn all GIFs](cgi3.jpe)](http://burnallgifs.org/)
