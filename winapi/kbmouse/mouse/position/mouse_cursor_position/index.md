---
Title: Как определить координаты курсора мыши?
Author: Spawn
Date: 01.01.2007
---


Как определить координаты курсора мыши?
=======================================

::: {.date}
01.01.2007
:::

GetCursorPos()

Автор: Spawn

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Обрабатывай событие OnMouseMove. Координаты курсора можно получить
следующим путем:

    procedure TForm1.FormMouseMove(Sender: TObject; Shift: TShiftState; X, Y: Integer);
    begin

     
       if (X >= 40 or X <= 234) and (Y >= 60 or Y <=258) then {здесь запуск твоей функции};
    end;

Автор: Pegas

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------


      mouse.CursorPos.x
      mouse.CursorPos.y

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Для этого можно воспользоваться API функцией GetCursorPos. Передав в эту
функцию TPoint, мы получим текущие координаты курсора. Следующий код
показывает, как получить значения координат курсора по нажатию кнопки.

    procedure Form1.Button1Click(Sender: TObject);
    var
      foo: TPoint;
    begin
      GetCursorPos(foo)
      ShowMessage( '(' + IntToStr(foo.X) + ',' + IntToStr( foo.Y ) + ')' );
    end;

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

Для этого можно воспользоваться API функцией GetCursorPos. Передав в эту
функцию TPoint, мы получим текущие координаты курсора. Следующий код
показывает, как получить значения координат курсора по нажатию кнопки.

     
    procedure Form1.Button1Click(Sender: TObject);
    var
      foo: TPoint;
    begin
      GetCursorPos(foo);
      ShowMessage('(' + IntToStr(foo.X) + ',' + IntToStr(foo.Y) + ')');
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
