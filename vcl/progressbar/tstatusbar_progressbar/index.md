---
Title: Вставить TProgressBar в TStatusBar
Date: 01.01.2007
---


Вставить TProgressBar в TStatusBar
==================================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

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


--------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

pgProgress положить на форму как `Visible := false`;

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


