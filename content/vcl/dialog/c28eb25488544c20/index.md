---
Title: Диалог отключения сетевого диска
Date: 01.01.2007
---


Диалог отключения сетевого диска
================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Открытие диалогового окна «Отключение сетевого диска»
     
    Зависимости: Windows
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        21 мая 2002 г.
    ********************************************** }
     
    function DisconnectNetworkDrive(Wnd: HWND = 0): DWORD;
    begin
     if Wnd = 0 then Wnd:=FindWindow('Shell_TrayWnd','');
     Result:=WNetDisconnectDialog(Wnd, RESOURCETYPE_DISK);
    end; 

Пример использования:

    DisconnectNetworkDrive(Application.Handle); 
