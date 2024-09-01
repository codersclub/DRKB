---
Title: Перемещение контролов мышкой во время выполнения приложения
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Перемещение контролов мышкой во время выполнения приложения
===========================================================

Для этого необходимо перехватить событие OnMouseDown, запомнив
координаты x и y и захватить мышку. После этого можно будет отслеживать
движение мышки при помощи события OnMouseMove, перемещая контрол пока
срабатывает событие OnMouseUp. Затем надо поместить контрол на своё
окончательное место и снять захват мышки.

Следующий пример показывает как мышкой двигать компонент TButton по
форме.

    type
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1MouseDown(Sender: TObject; Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer);
        procedure Button1MouseMove(Sender: TObject; Shift: TShiftState; X,
          Y: Integer);
        procedure Button1MouseUp(Sender: TObject; Button: 
          TMouseButton; Shift: TShiftState; X, Y: Integer);
      private
        { Private declarations }
      public
        { Public declarations }
        MouseDownSpot : TPoint;
        Capturing : bool;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.Button1MouseDown(Sender: TObject;
    Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
    begin
      if ssCtrl in Shift then begin
        SetCapture(Button1.Handle);
        Capturing := true;
        MouseDownSpot.X := x;
        MouseDownSpot.Y := Y;
      end;
    end;
     
    procedure TForm1.Button1MouseMove(Sender: TObject;
    Shift: TShiftState; X,  Y: Integer);
    begin
      if Capturing then begin
        Button1.Left := Button1.Left - (MouseDownSpot.x - x);
        Button1.Top := Button1.Top - (MouseDownSpot.y - y);
      end;
    end;
     
    procedure TForm1.Button1MouseUp(Sender: TObject; Button: 
        TMouseButton; Shift: TShiftState; X, Y: Integer);
    begin
      if Capturing then begin
        ReleaseCapture;
        Capturing := false;
        Button1.Left := Button1.Left - (MouseDownSpot.x - x);
        Button1.Top := Button1.Top - (MouseDownSpot.y - y);
      end;
    end;

