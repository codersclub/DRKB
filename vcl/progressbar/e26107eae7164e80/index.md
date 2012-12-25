---
Title: Вставить TProgressBar в TStatusBar
Date: 01.01.2007
---


Вставить TProgressBar в TStatusBar
==================================

::: {.date}
01.01.2007
:::

    procedure TForm1.FormCreate(Sender: TObject);
    begin
      with ProgressBar1 do
      begin
        Parent := StatusBar1;
        Position := 100;
        Top := 2;
        Left := 0;
        Height := StatusBar1.Height - Top;
        Width := StatusBar1.Panels[0].Width - Left;
      end;
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

pgProgress положить на форму как Visible := false;

StatusPanel надо OwnerDraw сделать и pефpешить, если Position меняется.

    procedure TMainForm.stStatusBarDrawPanel(StatusBar: TStatusBar;
    Panel: TStatusPanel; const Rect: TRect);
    begin
      if Panel.index = pnProgress then
      begin
        pgProgress.BoundsRect := Rect;
        pgProgress.PaintTo(stStatusBar.Canvas.Handle, Rect.Left, Rect.Top);
      end;
    end; 

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
