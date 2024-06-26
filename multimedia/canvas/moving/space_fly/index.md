---
Title: «Сквозь Вселенную» с дополнительными возможностями
Date: 01.08.2003
Author: Dimka Maslov, mainbox@endimus.ru
---


«Сквозь Вселенную» с дополнительными возможностями
==================================================

    { **** UBPFD *********** by delphibase.endimus.com ****
    >> "Сквозь Вселенную" с дополнительными возможностями
     
    Демонстрационный пример, динамически рисующий "движение среди звёзд" с вращением.
     
    Зависимости: Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        1 августа 2003 г.
    ***************************************************** }
     
    unit Starfields;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs;
     
    type
      TForm1 = class(TForm)
        procedure FormCreate(Sender: TObject);
        procedure FormPaint(Sender: TObject);
        procedure FormResize(Sender: TObject);
      private
        procedure AB00(var Message); message $AB00;
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    type
      TPoint = packed record
        X, Y, Z, R, Phi: Double;
      end;
     
    const
      NumStars = 2000; // Количество звёзд,
      // управляет общей плотностью звёздного поля
     
      RangeY = 7000; // Максимальное расстояние от картинной плоскости до звезды,
      // управляет плотностью звёзд в центре
     
      RangeR = 7000; // Максимальное радиальное удаление от луча зрения до звезды,
      // управляет плотностью звёзд по краям
     
      Height = 5000; // Высота наблюдателя,
      // управляет положением центра изображения по вертикали
     
      Basis = 100; // Расстояние до картинной плоскости
      // управляет соотношением количества звёзд в центре к их
      // количеству по краям
     
      DeltaY = 5; // Шаг изменения координаты, управляет скоростью движения
      DeltaT = 0.01; // Приращение времени, управляет скоростью вращения
      Period1 = 0.1; // Период вращения звёзд
      Amplitude2 = 0.5; // Амплитуда вращательных колебаний звёзд
      Period2 = 1.0; // Период вращательных колебаний
      Period3 = 0.1; // Период изменения направления движения звёзд.
     
      Direction = 1; // Направление движения 1 - к наблюдателю, -1 - от него
     
    var
      Stars: array[1..NumStars] of TPoint;
      Time: Double = 0;
      X0: Integer = 0;
      Y0: Integer = 0;
     
    procedure InitializeStars;
    var
      i: Integer;
    begin
      Randomize;
      for i := 1 to NumStars do
        with Stars[i] do
        begin
          Y := Random(RangeY);
          R := RangeR - 2 * Random(RangeR);
          Phi := Random(628) / 100;
        end;
    end;
     
    procedure Perspective(const X, Y, Z, Height, Basis: Double; var XP, YP: Double);
    var
      Den: Double;
    begin
      Den := Y + Basis;
      if Abs(Den) < 1E-100 then
        Den := 1E-100;
      XP := Basis * X / Den;
      YP := (Basis * Z + Height * Y) / Den;
    end;
     
    function KeyPressed(VKey: Integer): LongBool;
    asm
       push eax
       call GetKeyState
       and eax, 0080h
       shr al, 7
    end;
     
    procedure TForm1.AB00(var Message);
    begin
      if KeyPressed(VK_ESCAPE) then
        Close
      else
        Repaint;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      InitializeStars;
      DoubleBuffered := True;
    end;
     
    procedure TForm1.FormPaint(Sender: TObject);
    var
      X, Y: Double;
      L, T: Integer;
      i: Integer;
      D: Double;
    begin
      for i := 1 to NumStars do
      begin
        Application.ProcessMessages;
        with Stars[i] do
        begin
          D := Direction * sin(Period3 * Time);
          Y := Y - D * DeltaY;
          X := R * sin((Period1 * Time + Phi) + Amplitude2 * cos(Period2 * time));
          Z := R * cos((Period1 * Time + Phi) + Amplitude2 * cos(Period2 * time));
          if D > 0 then
          begin
            if Y < 0 then
            begin
              Y := RangeY;
              R := RangeR - 2 * Random(RangeR);
              // Phi := Random(628) / 100;
            end;
          end
          else
          begin
            if Y > RangeY then
            begin
              Y := 0;
              R := RangeR - 2 * Random(RangeR);
              // Phi := Random(628) / 100;
            end;
          end;
        end;
        Perspective(Stars[i].X, Stars[i].Y, Stars[i].Z, Height, Basis, X, Y);
        L := X0 + Round(X);
        T := Y0 - Round(Y);
        Canvas.Pen.Color := clWhite;
        if Stars[i].Y < RangeY / 4 then
        begin
          Canvas.Rectangle(L, T, L + 2, T + 2);
        end
        else
        begin
          Canvas.MoveTo(L, T);
          Canvas.LineTo(L + 1, T + 1);
        end;
      end;
      PostMessage(Handle, $AB00, 0, 0);
      Time := Time + DeltaT;
    end;
     
    procedure TForm1.FormResize(Sender: TObject);
    begin
      X0 := ClientWidth div 2;
      Y0 := ClientHeight * 3 div 2;
    end;
     
    end.
