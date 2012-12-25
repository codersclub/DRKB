---
Title: Програмное выключение клавиатуры и мыши
Author: Radmin
Date: 01.01.2007
---


Програмное выключение клавиатуры и мыши
=======================================

::: {.date}
01.01.2007
:::

    winexec(Pchar('rundll32 keyboard,disable' ) ,sw_Show); Клава OFF 
    winexec(Pchar('rundll32 mouse,disable' ) ,sw_Show); Маус OFF 

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

Автор: Radmin

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

BlockInput(), живёт в user32.dll

Автор: Song

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

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

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

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

Взято с <https://delphiworld.narod.ru>
