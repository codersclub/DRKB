---
Title: Скрыть Tray, часы, кнопку «пуск», панель задач
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Скрыть Tray, часы, кнопку «пуск», панель задач
==============================================

    program proga2;
     
    uses
      Windows;
     
    var
      Wnd: THandle; { объявляем переменные }
      int: integer;
     
    begin
      Randomize; { холостой прогон генератора случайных чисел }
      int := Random(3); { выбор одного варианта из четырёх }
      case int of
        0: { если первый вариант то }
        begin
          Wnd := FindWindow('Progman', nil);
          Wnd := FindWindowEx(Wnd, HWND(0), 'ShellDll_DefView', nil);
          { прячем трей }
          ShowWindow(Wnd, sw_hide);
        end;
        1: { если второй вариант то }
        begin
          Wnd := FindWindow('Shell_TrayWnd', nil);
          Wnd := FindWindowEx(Wnd, HWND(0), 'TrayNotifyWnd', nil);
          Wnd := FindWindowEx(Wnd, HWND(0), 'TrayClockWClass', nil);
          { прячем часы }
          ShowWindow(Wnd, sw_hide);
        end;
        2:
        begin
          Wnd := FindWindow('Shell_TrayWnd', nil);
          Wnd := FindWindowEx(Wnd, HWND(0), 'Button', nil);
          {прячем кнопку "Пуск"}
          ShowWindow(Wnd, sw_hide);
      end;
      3:
      begin
        Wnd := FindWindow('Shell_TrayWnd', nil);
        Wnd := FindWindowEx(Wnd, HWND(0), 'TrayNotifyWnd', nil);
        { прячем "Панель задач" }
        ShowWindow(Wnd, sw_hide);
      end;
    end;
     
    end.

