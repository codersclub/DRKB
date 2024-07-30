---
Title: OwnerDraw в компоненте TStatusBar
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


OwnerDraw в компоненте TStatusBar
=================================

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


