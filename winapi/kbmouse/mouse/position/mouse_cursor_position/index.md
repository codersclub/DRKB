---
Title: Как определить координаты курсора мыши?
Date: 01.01.2007
---


Как определить координаты курсора мыши?
=======================================

Вариант 1:

Author: Spawn

Source: Vingrad.ru <https://forum.vingrad.ru>

    GetCursorPos()

------------------------------------------------------------------------

Вариант 2:

Author: Pegas

Source: Vingrad.ru <https://forum.vingrad.ru>

Обрабатывай событие OnMouseMove. Координаты курсора можно получить
следующим путем:

    procedure TForm1.FormMouseMove(Sender: TObject; Shift: TShiftState; X, Y: Integer);
    begin
       if (X >= 40 or X <= 234) and (Y >= 60 or Y <=258) then {здесь запуск твоей функции};
    end;

------------------------------------------------------------------------

Вариант 3:

Author: Vit

Source: Vingrad.ru <https://forum.vingrad.ru>

    mouse.CursorPos.x
    mouse.CursorPos.y

------------------------------------------------------------------------

Вариант 4:

Source: <https://forum.sources.ru>

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

------------------------------------------------------------------------

Вариант 5:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

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

