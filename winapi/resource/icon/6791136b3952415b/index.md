---
Title: Как вшить иконку в мою прогу с нуля?
Author: Rouse\_
Date: 01.01.2007
---

Как вшить иконку в мою прогу с нуля?
====================================

::: {.date}
01.01.2007
:::

в .RC - файле подключаемом к проекту пишешь\

 

    100 ICON "100.ico"

 \

для загрузки икоки:

      with MainWindow do
      begin

     
        cbSize := SizeOf(MainWindow);
        style := CS_HREDRAW or CS_VREDRAW;
        lpfnWndProc := @WindowProc;
        cbClsExtra := 0;
        cbWndExtra := 0;
        hIcon := LoadIcon(0, IDI_APPLICATION);
        hCursor  := LoadCursor(0, IDC_ARROW);
        hbrBackground := COLOR_BTNFACE + 1;
        lpszMenuName := nil;
        lpszClassName := 'TDeliveryInstaller';
      end;
      MainWindow.hInstance := HInstance;
      if RegisterClassEx(MainWindow) = 0 then Exit;
     
      Width := 360;
      Height := 200;
     
      InitCommonControls;
     
      Handle := CreateWindowEx(0, 'TDeliveryInstaller',
        PChar(TXT_CAPTION), WS_OVERLAPPED or WS_SYSMENU,
        Left, Top, Width, Height, 0, 0, HInstance, nil);
     
      SendMessage(Handle, WM_SETICON, 1, LoadIcon(HInstance, MAKEINTRESOURCE(100)));

 \

Взято из <https://forum.sources.ru>

Автор: Rouse\_
