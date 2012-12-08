---
Title: Счетчик посещений на Delphi
Date: 01.01.2007
---


Счетчик посещений на Delphi
===========================

::: {.date}
01.01.2007
:::

Счетчики предназначены для учета количества посетителей на Ваш сайт.
Кроме этого на счетчик можно возложить операции ведения статистики, учет
хостов откуда пришли посетители и т.д.

Данный пример демонстрирует работу простого текстового счетчика с
ведением списка IP адресов посетителей.

Сначала пропишем обработчик WebActionItem

    procedure TWM.WMWebActionItemMainAction(Sender: TObject;
        Request: TWebRequest; Response: TWebResponse; var Handled: Boolean);
    var
        f:TextFile;
    begin
        Response.Content:=SetCounter; // Устанавливаем счетчик
     
        // Записываем IP посетителя
        AssignFile(f,log_path);
        Append(f);
        Writeln(f,Request.RemoteAddr);
        CloseFile(f);
    end;
    Осталось реализовать функцию SetCounter 
    function TWM.SetCounter: String;
    var
        f:TextFile;
        count:Integer;
    begin
        AssignFile(f,counter_path);
        Reset(f);
        // Считываем значение счетчика
        Readln(f,count);
        CloseFile(f);
        //Инкреминируем
        Inc(count);
        Rewrite(f);
        // Записываем
        writeln(f,count);
        CloseFile(f);
        Result:=IntToStr(count);
    end;

И еще необходимо определить константы имен файлов const

        counter_path='counter.dat'; // Файл для значений счетчика
        log_path='counter.log'; // Файл для IP адресов

Для работы этого скрипта необходимо создать два файла, для ведения счета
и для списка IP. В файле счета необходимо установить начальное значение
счетчика, сделать это можно в любом текстовом редакторе.

Источник: <https://codenet.ru>

------------------------------------------------------------------------

 

Счетчик посещений это первое, в чем нуждается популярный web сайт. Меня
всегда интересует количество людей посетивших мой сайт. Я всегда
заинтересован знать количество людей каждый день. И я всегда
заинтересован знать, как выходные и праздники влияют на посещения.

Для отслеживания количества посетителей я просто создан однострочный
файл, назвав его \"counter\", который содержит количество посещений.
Единственная вещь, которая нам требуется, это простая CGI программа,
которая читает этот файл, увеличивает на единичку и записывает обратно.
Конечно, прекрасно при этом показывать посетителю эту информацию или в
виде картинки или в виде простого текстового сообщения.

      {$APPTYPE CONSOLE}
      {$I-}
      var
        f: Text;
        i: Integer;
      begin
        System.Assign(f,'counter');
        reset(f);
        if IOResult = 0 then readln(f,i)
                        else i := 0;
        Inc(i);
        rewrite(f);
        writeln(f,i);
        close(f);
        if IOResult <> 0 then { skip };
        writeln('Content-type: text/html');
        writeln;
        writeln('<HTML>');
        writeln('<BODY>');
        writeln('<CENTER>');
        writeln('You are user <B>',i,'</B> of Dr.Bobs Delphi Clinic');
        writeln('</CENTER>');
        writeln('</BODY>');
        writeln('</HTML>')
      end.

Выше приведенная программа показывает текущее значение в виде текстового
сообщения, которое выводится в отдельном фрейме:

      <HTML>
      <FRAMESET ROWS="64,*">
        <FRAME SRC=http://www.drbob42.com/cgi-bin/hitcount.exe? NAME="Head">
        <FRAME  SRC="guest.htm"NAME="Main">
      </FRAMESET>
      </HTML>

 

Это очень простое CGI приложение. Оно даже не получает ввода, просто
преобразовывает удаленный файл на web сервере и возвращает динамическую
страницу. Позвольте теперь сделать фокус на более сложном CGI приложении
- таком которое требует ввода данных - например гостевой книге.

 

Интернет решения от доктора Боба (http://www.drbob42.com)

\(c) 2000, Анатолий Подгорецкий, перевод на русский язык
(<https://nps.vnet.ee/ftp>)
