---
Title: Как сделать прямоугольник для выделения части картинки для редактирования?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Как сделать прямоугольник для выделения части картинки для редактирования?
==========================================================================

Самый простой способ - воспользоваться функцией Windows API
DrawFocusRect. Функция DrawFocusRect использует операцию XOR при
рисовании - таким образом вывод прямоугольника дважды с одними и теми же
координатами стирает прямоугольник, и прямоугольник всегда будет виден,
на фоне какого бы цвета он не выводился.

    type
      TForm1 = class(TForm)
        procedure FormMouseDown(Sender: TObject; Button: TMouseButton;
        Shift: TShiftState; X, Y: Integer);
        procedure FormMouseMove(Sender: TObject;
        Shift: TShiftState; X, Y: Integer);
        procedure FormMouseUp(Sender: TObject; Button: TMouseButton;
        Shift: TShiftState; X, Y: Integer);
      private
        {Private declarations}
        Capturing : bool;
        Captured : bool;
        StartPlace : TPoint;
        EndPlace : TPoint;
      public
        {Public declarations}
    end;
     
    var
      Form1: TForm1;
     
    implementation
    {$R *.DFM}
     
    function MakeRect(Pt1: TPoint; Pt2: TPoint): TRect;
    begin
      if pt1.x < pt2.x then
      begin
        Result.Left := pt1.x;
        Result.Right := pt2.x;
      end
      else
      begin
        Result.Left := pt2.x;
        Result.Right := pt1.x;
      end;
      if pt1.y < pt2.y then
      begin
        Result.Top := pt1.y;
        Result.Bottom := pt2.y;
      end
      else
      begin
        Result.Top := pt2.y;
        Result.Bottom := pt1.y;
      end;
    end;
     
    procedure TForm1.FormMouseDown(Sender: TObject; Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);
    begin
      if Captured then
        DrawFocusRect(Form1.Canvas.Handle,MakeRect(StartPlace, EndPlace));
      StartPlace.x := X;
      StartPlace.y := Y;
      EndPlace.x := X;
      EndPlace.y := Y;
      DrawFocusRect(Form1.Canvas.Handle, MakeRect(StartPlace, EndPlace));
      Capturing := true;
      Captured := true;
    end;
     
    procedure TForm1.FormMouseMove(Sender: TObject;
    Shift: TShiftState; X, Y: Integer);
    begin
      if Capturing then
      begin
        DrawFocusRect(Form1.Canvas.Handle,MakeRect(StartPlace,EndPlace));
        EndPlace.x := X;
        EndPlace.y := Y;
        DrawFocusRect(Form1.Canvas.Handle,MakeRect(StartPlace,EndPlace));
      end;
    end;
     
    procedure TForm1.FormMouseUp(Sender: TObject; Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);
    begin
      Capturing := false;
    end;


