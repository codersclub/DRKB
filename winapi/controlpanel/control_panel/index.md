---
Title: Как запустить любой апплет панели управления?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как запустить любой апплет панели управления?
=============================================

Апплеты в панели управления можно запускать при помощи функции WinExec,
запуская control.exe и передав ей в качестве параметра имя апплета.
Файлы апплетов (.cpl) обычно находятся в системной директории Windows.

Некоторые из апплетов могут располагаться за пределами системной
директории, поэтому их прийдётся запускать просто по имени.

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      WinExec('C:\WINDOWS\CONTROL.EXE TIMEDATE.CPL', 
           sw_ShowNormal);
      WinExec('C:\WINDOWS\CONTROL.EXE MOUSE', 
           sw_ShowNormal);
      WinExec('C:\WINDOWS\CONTROL.EXE PRINTERS', 
           sw_ShowNormal);
    end;

