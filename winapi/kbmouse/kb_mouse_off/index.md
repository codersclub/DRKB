---
Title: Програмное выключение клавиатуры и мыши
Author: Radmin
Date: 01.01.2007
---


Програмное выключение клавиатуры и мыши
=======================================

Вариант 1:

Author: Radmin

Source: Vingrad.ru <https://forum.vingrad.ru>


    winexec(Pchar('rundll32 keyboard,disable'),sw_Show); //Клава OFF 
    winexec(Pchar('rundll32 mouse,disable'),sw_Show);    //Маус OFF 

кстати а вот так клава врубается

Отрубить

    Asm 
      in al,21h
      or al,00000010b
      out 21h,al
    End;

Врубить

    Asm 
      in al,21h
      mov al,0
      out 21h,al
    End;

------------------------------------------------------------------------

Вариант 2:

Author: Song

Source: Vingrad.ru <https://forum.vingrad.ru>

BlockInput(), живёт в user32.dll

------------------------------------------------------------------------

Вариант 3:

Source: <https://forum.sources.ru>

Как скрыть курсор мышки

Поместите в событие OnClick в button1 и button2 следующие коды.Если
курсор мышки скрыт, то выбрать button2 можно клавишей Tab.

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ShowCursor(False);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      ShowCursor(True);
    end;


------------------------------------------------------------------------

Вариант 4:

Source: <https://delphiworld.narod.ru>

    //Выключение курсора
    procedure TForm1.Button1Click(Sender: TObject);
    var
      CState: Integer;
    begin
      CState := ShowCursor(True);
      while Cstate >= 0 do
        Cstate := ShowCursor(False);
    end;
     
    //Включение курсора
    procedure TForm1.Button2Click(Sender: TObject);
    var
      Cstate: Integer;
    begin
      Cstate := ShowCursor(True);
      while CState < 0 do
        CState := ShowCursor(True);
    end;

