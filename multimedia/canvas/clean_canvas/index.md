---
Title: Как очистить Canvas?
Author: Даниил Карапетян (delphi4all\@narod.ru)
Date: 01.01.2007
---


Как очистить Canvas?
====================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    begin
      PatBlt(Form1.Canvas.Handle,0,0,Form1.ClientWidth,Form1.ClientHeight,WHITENESS);
    end;

Взято из <https://forum.sources.ru>

------------------------------------------------------------------------

    Canvas.Brush.Color := ClWhite;
    Canvas.FillRect(Canvas.ClipRect);

------------------------------------------------------------------------

    InValidateRect(Canvas.handle,NIL,True);

(или взамен передать дескриптор компонента)

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

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

Автор: Даниил Карапетян (delphi4all\@narod.ru)

Автор справки: Алексей Денисов (aleksey\@sch103.krasnoyarsk.su)

------------------------------------------------------------------------

    InValidateRect(Canvas.handle,NIL,True);

Если вы используете холст формы, то попробуйте следующее:

     
    InValidateRect(form1.handle,NIL,True); 

(или взамен передать дескриптор компонента)

Это очистит хост:

    canvas.fillrect(canvas.cliprect);

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
