---
Title: Рисование квадрата мышкой
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Рисование квадрата мышкой
=========================

    private
       { Private declarations }
       AnchorX, AnchorY,
       CurX, CurY: Integer;
       Bounding: Boolean;
     end;
     
     implementation
     
     procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
       Shift: TShiftState; X, Y: Integer);
     begin
       AnchorX := X;
       CurX := X;
       AnchorY  := Y;
        CurY := Y;
       Bounding := True;
     end;
     
     procedure TForm1.FormMouseMove(Sender: TObject; Shift: TShiftState; X,
       Y: Integer);
     begin
       if Bounding then
        begin
         Canvas.Pen.Mode := pmNot;
         Canvas.Pen.Width := 2;
         Canvas.Brush.Style := bsClear;
         Canvas.Rectangle(AnchorX, AnchorY, CurX, CurY);
         CurX := X;
          CurY := Y;
         Canvas.Rectangle(AnchorX, AnchorY, CurX, CurY);
       end;
     end;
     
     procedure TForm1.FormMouseUp(Sender: TObject; Button: TMouseButton;
       Shift: TShiftState; X, Y: Integer);
     begin
       if Bounding then
        begin
         Bounding := False;
         Canvas.Pen.Mode := pmNot;
         Canvas.Brush.Style := bsClear;
         Canvas.Rectangle(AnchorX, AnchorY, CurX, CurY);
       end;
     end;

