---
Title: Копировать векторное изображение
Date: 01.01.2007
---


Копировать векторное изображение
================================

::: {.date}
01.01.2007
:::

    procedure TForm1.Button1Click(Sender: TObject);
    var
      mf: TMetaFile;
      mfc: TMetaFileCanvas;
      i: integer;
      ClipBrdFormat: word;
      data: cardinal;
      palette: hPalette;
      p: array [0..90] of TPoint;
    begin
      mf := TMetaFile.Create;
      mf.Width := 100;
      mf.Height := 100;
      mfc := TMetafileCanvas.Create(mf, 0);
      with mfc do
      begin
        Pen.Color := clBlack;
        FrameRect(ClipRect);
     
        MoveTo(0, 50);
        LineTo(100, 50);
        LineTo(95, 48);
        MoveTo(100, 50);
        LineTo(95, 52);
     
        MoveTo(50, 100);
        LineTo(50, 0);
        LineTo(48, 5);
        MoveTo(50, 0);
        LineTo(52, 5);
     
        Brush.Style := bsClear;
        Font.name := 'arial';
        Font.Size := 6;
        TextOut(55, 0, 'Y');
        TextOut(95, 38, 'X');
     
        Pen.Color := clRed;
        for i := low(p) to high(p) do
          p[i] := Point(i, round(50 - 30 * sin((i - 50) / 5)));
        Polyline(p);
      end;
      mfc.Free;
      mf.SaveToClipboardFormat(ClipBrdFormat, data, palette);
     
      OpenClipboard(Application.Handle);
      EmptyClipboard;
      SetClipboardData(ClipBrdFormat, data);
      CloseClipboard;
     
     
      mf.Inch := 200;
      Form1.Canvas.Draw(0, 0, mf);
      mf.Free;
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
