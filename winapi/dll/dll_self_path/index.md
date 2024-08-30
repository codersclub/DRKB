---
Title: Как найти полный путь и имя файла запущенной DLL из самой DLL?
Date: 01.01.2007
---


Как найти полный путь и имя файла запущенной DLL из самой DLL?
==============================================================

Вариант 1:

Author: Олег Кулабухов

Source: <https://forum.sources.ru>

Следующий пример демонстрирует функцию, которая позволяет определить
полный путь откуда была загружена dll:

    uses Windows;
     
    procedure ShowDllPath stdcall;
    var
      TheFileName: array[0..MAX_PATH] of char;
    begin
      FillChar(TheFileName, sizeof(TheFileName), #0);
      GetModuleFileName(hInstance, TheFileName, sizeof(TheFileName));
      MessageBox(0, TheFileName, 'The DLL file name is:', mb_ok);
    end;

------------------------------------------------------------------------

Вариант 2:

Source: <https://delphiworld.narod.ru>

    function GetModuleFileNameStr(Instance: THandle): string;
    var
      buffer: array [0..MAX_PATH] of Char;
    begin
      GetModuleFileName( Instance, buffer, MAX_PATH);
      Result := buffer;
    end;
     
    GetModuleFileNameStr(Hinstance); // dll name
    GetModuleFileNameStr(0); // exe name

