---
Title: Реализовать фоновую работу программы
Date: 01.01.2007
---


Реализовать фоновую работу программы
====================================

Попробуйте запустить программу. Пока компьютер ничего не делает, рисунок
на окне все время меняется, но, стоит загрузить компьютер какой-либо
работой, и изменение фона прекращается. В этой программе можно подвигать
мышью по окну - это приведет к сравнительно сложным действиям, поэтому
фоновая работа программы временно прекратится.

     
    ...
    public
      Row: integer;
      procedure OnIdleProc(Sender: TObject; var Done: Boolean);
    ...
    procedure TForm1.FormCreate(Sender: TObject);
     
    begin
      Application.OnIdle := OnIdleProc;
    end;
     
    procedure TForm1.OnIdleProc(Sender: TObject; var Done: Boolean);
    var
      i: integer;
      col: TColor;
      Gray: integer;
    begin
      for i := 0 to Form1.ClientWidth - 1 do begin
        col := Form1.Canvas.Pixels[i, Row];
        Gray := GetRValue(col) + round(30 * sin(i / 30 + Row / 50));
        Form1.Canvas.Pixels[i, Row] := RGB(Gray, Gray, Gray);
      end;
     
      inc(Row);
      if (Row = Form1.ClientHeight) then Row := 0;
      Done := false;
    end;
     
    procedure TForm1.FormMouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
    var
      i: integer;
    begin
      with Form1.Canvas do begin
        Brush.Style := bsClear;
        for i := 0 to 1000 do begin
          Pen.Color := RGB(i, i, i);
          Rectangle(X - i, Y - i, X + i, Y + i);
     
        end;
      end;
    end;
