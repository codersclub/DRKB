---
Title: Как найти полный путь и имя файла запущенной DLL из самой DLL?
Author: Олег Кулабухов
Date: 01.01.2007
---


Как найти полный путь и имя файла запущенной DLL из самой DLL?
==============================================================

::: {.date}
01.01.2007
:::

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

Автор: Олег Кулабухов

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------
Вариант 2:

    function GetModuleFileNameStr(Instance: THandle): string;
    var
      buffer: array [0..MAX_PATH] of Char;
    begin
      GetModuleFileName( Instance, buffer, MAX_PATH);
      Result := buffer;
    end;
     
    GetModuleFileNameStr(Hinstance); // dll name
    GetModuleFileNameStr(0); // exe name

Взято с <https://delphiworld.narod.ru>
