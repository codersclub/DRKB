---
Title: Счетчик посещений на Delphi
Date: 01.01.2007
Source: <https://codenet.ru>
---


Счетчик посещений на Delphi
===========================

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
