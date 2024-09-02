---
Title: Как автоматически помещать курсор мышки в центр контрола получившего фокус?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как автоматически помещать курсор мышки в центр контрола получившего фокус?
===========================================================================

Нам потребуется универсальная функция, которую можно будет применять для
различных визуальных контролов.

Вот пример вызова нашей функции:

    procedure TForm1.Button1Enter(Sender: TObject);
    begin
      MoveMouseOverControl(Sender);
    end;

Сама функция:

    procedure MoveMouseOverControl(Sender: TObject);
    var
      Point: TPoint;
    begin
      with TControl(Sender) do
      begin
        Point.X := Left + (Width  div 2);
        Point.Y := Top +  (Height div 2);
        Point := Parent.ClientToScreen(Point);
        SetCursorPos(Point.X, Point.Y);
      end;
    end;

Исправлено Stolzen
