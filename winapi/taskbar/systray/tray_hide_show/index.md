---
Title: Показываем / Скрываем System Tray
Author: Ruslan Abu Zant
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Показываем / Скрываем System Tray
=================================

Вы, наверное, видели множество примеров, которые показывают как скрывать
панель задач или кнопку Пуск. Но вот как скрыть только System Tray ?

    procedure hideStartbutton(visi: boolean);
    var
      Tray, Child: hWnd;
      C: array[0..127] of Char;
      S: string;
     
    begin
      Tray := FindWindow('Shell_TrayWnd', nil);
      Child := GetWindow(Tray, GW_CHILD);
      while Child <> 0 do
        begin
          if GetClassName(Child, C, SizeOf(C)) > 0 then
            begin
              S := StrPAS(C);
              if UpperCase(S) = 'TRAYNOTIFYWND' then
                begin
                  if Visi then
                    ShowWindow(Child, 1)
                  else
                    ShowWindow(Child, 0);
                end;
            end;
          Child := GetWindow(Child, GW_HWNDNEXT);
        end;
    end;

для того, чтобы обатно её показать, используйте

    hideStartbutton(true);

или `hideStartbutton(false);` чтобы скрыть !!

