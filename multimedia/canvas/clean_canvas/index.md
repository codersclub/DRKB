---
Title: Как очистить Canvas?
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Как очистить Canvas?
====================

Вариант 1:

Source: <https://forum.sources.ru>

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      PatBlt(Form1.Canvas.Handle,0,0,Form1.ClientWidth,Form1.ClientHeight,WHITENESS);
    end;


------------------------------------------------------------------------

Вариант 2:

    Canvas.Brush.Color := ClWhite;
    Canvas.FillRect(Canvas.ClipRect);

------------------------------------------------------------------------

Вариант 3:

Source: <https://delphiworld.narod.ru>

    InValidateRect(Canvas.handle,NIL,True);

(или взамен передать дескриптор компонента)


------------------------------------------------------------------------

Вариант 4:

Author: Даниил Карапетян (delphi4all@narod.ru)

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)

Есть два хороших способа очистить Canvas. Их скорости очень близки. В
первом способе используются возможности Delphi, во втором - WinAPI.
Первый способ удобнее тем, что позволяет закрашивать Canvas любым
цветом.

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      Form1.Canvas.Brush.Color := clRed;
      Form1.Canvas.FillRect(Form1.ClientRect);
      PatBlt(Form1.Canvas.Handle, 0, 0,
        Form1.ClientWidth, Form1.ClientHeight, WHITENESS);
    end;

------------------------------------------------------------------------

Вариант 5:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    InValidateRect(Canvas.handle,NIL,True);

Если вы используете холст формы, то попробуйте следующее:

    InValidateRect(form1.handle,NIL,True); 

(или взамен передать дескриптор компонента)

Это очистит хост:

    canvas.fillrect(canvas.cliprect);


