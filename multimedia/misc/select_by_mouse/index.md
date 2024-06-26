---
Title: Как сделать выделение резиновым прямоугольником?
Date: 01.01.2007
Author: Даниил Карапетян, delphi4all@narod.ru
---


Как сделать выделение резиновым прямоугольником?
================================================

Как реализовать выделение "резиновым прямоугольником". Иными словами,
когда пользоватьль нажимает на левую кнопку мыши и сдвигает ее, на
экране появляется прямоугольник, изменяющий размеры при движении мыши,
причем все объекты, попавшие в этот прямоугольник выделяются.

В качестве объекта я взял Label, меняющий цвет в зависимости от того,
выделен он или нет. При нажатии мышью на форме в FirstPoint кладутся
координата курсора. При дальнейшем движении мыши координаты
прямоугольника будут высчитываться по FirstPoint и текущим координатам
курсора. Причем, чтобы программа нормально отрабатывала случай, когда
высота или ширина прямоугольника отрицательная (это произойдет, если
увести мышь левее или выше начальной точки), создана процедура
NormalRect. NormalRect устанавливает координаты прямоугольника sel по
координатам двух протвоположенных углов прямоугольника, вне зависимости
от порядка. DrawRect рисует на форме прямоугольник, использую режим XOR.
Благодаря этому режиму, чтобы стереть такой прямоугольник, достаточно
нарисовать его повторно.

Скачать необходимые для компиляции файлы проекта можно на
program.dax.ru/subscribe/.

    uses stdctrls;
    var
      Selecting: boolean = false;
      FirstPoint: TPoint;
      sel: TRect; 
     
    procedure DrawRect;
    begin
      with Form1.Canvas do begin
        Pen.Style := psDot;
        Pen.Color := clGray;
        Pen.Mode := pmXor;
        Brush.Style := bsClear;
        Rectangle(sel.Left, sel.Top, sel.Right, sel.Bottom);
      end;
    end; 
    
    procedure NormalRect(p1, p2: TPoint);
    begin
      if p1.x < p2.x then 
      begin
        sel.Left := p1.x;
        sel.Right := p2.x;
      end 
      else 
      begin
        sel.Left := p2.x;
        sel.Right := p1.x;
      end;
      if p1.y < p2.y then 
      begin
        sel.Top := p1.y;
        sel.Bottom := p2.y;
      end 
      else 
      begin
        sel.Top := p2.y;
        sel.Bottom := p1.y;
      end;
    end; 
    procedure TForm1.FormCreate(Sender: TObject);
    var i: integer;
    begin
      randomize;
      for i := 1 to random(5) + 5 do 
      begin
        with TLabel.Create(Form1) do 
        begin
          Caption := 'Label' + IntToStr(i);
          Left := random(Form1.ClientWidth - Width);
          Top := random(Form1.ClientHeight - Height);
          Visible := true;
          Parent := Form1;
        end;
      end;
    end; 
    procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
    begin
      if selecting or (Button <> mbLeft) then Exit;
      SetCapture(Form1.Handle);
      Selecting := true;
      FirstPoint := Point(X, Y);
      sel := Bounds(X, Y, 0, 0);
    end; 
    
    procedure TForm1.FormMouseMove(Sender: TObject; Shift: TShiftState; X, Y: Integer);
      procedure SelectLebel(lb: TLabel; r: TRect);
      var
        select: boolean;
        res: TRect;
      begin
        select := IntersectRect(res, lb.BoundsRect, r);
        if select and (lb.Color = clNavy) then Exit;
        if select then 
        begin
          lb.Color := clNavy;
          lb.Font.Color := clWhite;
        end 
        else 
        begin
          lb.Color := clBtnFace;
          lb.Font.Color := clBlack;
        end;
      end;
    
    var i: integer;
    begin
      if not Selecting then Exit;
      DrawRect;
      NormalRect(FirstPoint, Point(X, Y));
      for i := 0 to Form1.ComponentCount - 1 do
        if (Form1.Components[i] is TLabel) then
          SelectLebel(Form1.Components[i] as TLabel, sel);
      Application.ProcessMessages;
      DrawRect;
    end; 
     
    procedure TForm1.FormMouseUp(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      if (not Selecting) or (Button <> mbLeft) then Exit;
      NormalRect(FirstPoint, Point(X, Y));
      DrawRect;
      ReleaseCapture;
      Selecting := false;
    end; 


На сайте <https://delphi4all.narod.ru> Вы найдете еще более 100 советов
по Delphi.


