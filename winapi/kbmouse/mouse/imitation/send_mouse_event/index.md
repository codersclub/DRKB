---
Title: Как послать нажатие кнопки мыши в окно?
Author: Song
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Как послать нажатие кнопки мыши в окно?
=======================================

Вариант 1:

Author: Spawn

Source: Vingrad.ru <https://forum.vingrad.ru>

Для этого используйте события:

- WM\_LBUTTONDOWN
- WM\_RBUTTONDOWN


------------------------------------------------------------------------

Вариант 2:

Author: Song

Source: Vingrad.ru <https://forum.vingrad.ru>

> Я решил проверить точку нажатия мышки таким вот образом:
> 
>     ...
>     SetForegroundWindow(WindowUO);
>     mouse_event(MOUSEEVENTF_MOVE,400,400,0,0);
>     ...
> 
> и получилось, что мышка перемещалась не в те координаты (относительно
> разрешения монитора (800 на 600)) которые я задумал (вне зависимости от
> местоположения мышки она перемещалась строго по одному направлению на
> одинаковое расстояние), причем я сделал еще один вариант:
> `dx=100, dy=100`, но тогда перемещение мышки произошло в другую сторону
> (в сторону x=0 y=0 монитора)!
> 
> Подскажите плз в чем дело?

Mouse\_event программирует не абсолютные, а относительные координаты.

Чтобы не думалось, просто сначала установите курсор в нужную позицию -
SetCursorPos(), а потом делайте клик - Mouse\_event()

------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

На форму вынесите компонент TTimer и опишите его единственное событие
следующим образом:

    procedure TForm1.Timer1Timer(Sender: TObject);
    var
      x, y: Integer;
    begin
      x := random(Screen.Width);
      y := random(Screen.Height);
      sendmessage(Handle, WM_LBUTTONDOWN, MK_LBUTTON, x + y shl 16);
      sendmessage(Handle, WM_LBUTTONUP, MK_LBUTTON, x + y shl 16);
    end;

Для того, чтобы убедиться, что сообщения на самом деле посылаются,
давайте обработаем событие OnMouseDown для формы. Мы попытаем обозначать
те места, где якобы была нажата кнопка мыши.

    procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);
    begin
      Form1.Canvas.Ellipse(x - 2, y - 2, x + 2, y + 2);
    end; 



------------------------------------------------------------------------

Вариант 4:

Source: <https://www.swissdelphicenter.ch>

    // Set the mouse cursor to position x,y: 
    // Maus an Position x,y setzen: 
    SetCursorPos(x, y);
     
    // Simulate the left mouse button down 
    // Linke Maustaste simulieren 
    mouse_event(MOUSEEVENTF_LEFTDOWN, 0, 0, 0, 0);
    mouse_event(MOUSEEVENTF_LEFTUP, 0, 0, 0, 0);
     
    // Simulate the right mouse button down 
    // Rechte Maustaste simulieren 
    mouse_event(MOUSEEVENTF_RIGHTDOWN, 0, 0, 0, 0);
    mouse_event(MOUSEEVENTF_RIGHTUP, 0, 0, 0, 0);
     
    // Simulate a double click 
    // Einen Doppelklick simulieren 
    mouse_event(MOUSEEVENTF_LEFTDOWN, 0, 0, 0, 0);
    mouse_event(MOUSEEVENTF_LEFTUP, 0, 0, 0, 0);
    GetDoubleClickTime;
    mouse_event(MOUSEEVENTF_LEFTDOWN, 0, 0, 0, 0);
    mouse_event(MOUSEEVENTF_LEFTUP, 0, 0, 0, 0);
    
    // Simulate a double click on a panel 
    // Einen Doppelklick auf einen Panel simulieren 
    SendMessage(Panel1.Handle, WM_LBUTTONDBLCLK, 10, 10)

