---
Title: OwnerDraw в компоненте TStatusBar
Date: 01.01.2007
---


OwnerDraw в компоненте TStatusBar
=================================

::: {.date}
01.01.2007
:::

    procedure TForm1.StatusBar1DrawPanel(StatusBar: TStatusBar;
    Panel: TStatusPanel; const Rect: TRect);
    begin
      with statusbar1.Canvas do
      begin
        Brush.Color := clRed;
        FillRect(Rect);
        TextOut(Rect.Left, Rect.Top, 'Панель '+IntToStr(Panel.Index));
      end;
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
