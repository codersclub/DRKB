---
Title: Как выдавить текст?
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Как выдавить текст?
===================

Чтобы сделать текст выпуклым, нужно за светло-серой надписью разместить
точно такие же надписи, только белую чуть левее и выше и светло-серую
чуть правее и ниже.

Приведенная ниже программа выводит выпуклый текст, который вдавливается
при нажатии.

    const
      s = 'It is a text string';
      ColDark = clGray;
      ColNorm = clSilver;
      ColLight = clWhite;
      XPos = 10;
      YPos = 10;
      dx = 1;
      dy = 1;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      Form1.Canvas.Brush.Style := bsClear;
      with Form1.Canvas.Font do begin
        Name := 'Arial';
        Size := 20;
        Style := [fsBold];
     
      end;
    end;
     
    procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      with Form1.Canvas do begin
        Font.Color := ColDark;
        TextOut(XPos - dx, YPos - dy, s);
        Font.Color := ColLight;
        TextOut(XPos + dx, YPos + dy, s);
        Font.Color := ColNorm;
        TextOut(XPos, YPos, s);
      end;
    end;
     
    procedure TForm1.FormMouseUp(Sender: TObject; Button: TMouseButton;
     
      Shift: TShiftState; X, Y: Integer);
    begin
      with Form1.Canvas do begin
        Font.Color := ColLight;
        TextOut(XPos - dx, YPos - dy, s);
        Font.Color := ColDark;
        TextOut(XPos + dx, YPos + dy, s);
        Font.Color := ColNorm;
        TextOut(XPos, YPos, s);
      end;
    end;
     
    procedure TForm1.FormPaint(Sender: TObject);
    begin
      Form1.MouseUp(mbLeft, [], 0, 0);
    end;

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)
