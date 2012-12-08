---
Title: Определение полного пути и имени файла DLL
Date: 01.01.2007
---


Определение полного пути и имени файла DLL
==========================================

::: {.date}
01.01.2007
:::

Следующий пример демонстрирует функцию, которая позволяет определить
полный путь откуда была загружена dll:

    uses Windows;
     
    procedure ShowDllPath stdcall;
    var
      TheFileName : array[0..MAX_PATH] of char;
    begin
      FillChar(TheFileName, sizeof(TheFileName), #0);
      GetModuleFileName(hInstance, TheFileName, sizeof(TheFileName));
      MessageBox(0, TheFileName, 'The DLL file name is:', mb_ok);
    end;

Взято из <https://forum.sources.ru>
