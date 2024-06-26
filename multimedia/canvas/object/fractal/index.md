---
Title: Рисование фрактальных графов
Author: Михаил Марковский
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Рисование фрактальных графов
============================

Очередная нетленка, которую я предлагаю Вам, написана мной
самостоятельно (идею и примеры, реализованные в программе, я нашел в
апрельском номере журнала "Химия и жизнь" за 1995 год). Теоретически
она производит трансляцию L-систем с выводом образовавшихся фрактальных
графов, а практически рисует кусты и деревья. Вроде бесполезно, но очень
красиво. Эта программа написана для TP7, хотя легко переносится на
Delphi (как то я уже переводил ее, но модуль бесследно исчез). Буду
надеяться, что она придется Вам по душе.

    uses graph, crt;
     
    const
      GrafType = 1; {1..3}
     
    type
      PointPtr = ^Point;
      Point = record
        X, Y: Word;
        Angle: Real;
        Next: PointPtr
      end;
      GrfLine = array[0..5000] of
        Byte;
      ChangeType = array[1..30] of
        record
        Mean: Char;
        NewString: string
      end;
     
    var
      K, T, Dx, Dy, StepLength, GrafLength: Word;
      grDriver, Xt: Integer;
      grMode: Integer;
      ErrCode: Integer;
      CurPosition: Point;
      Descript: GrfLine;
      StartLine: string absolute Descript;
      ChangeNumber, Generation: Byte;
      Changes: ChangeType;
      AngleStep: Real;
      Mem: Pointer;
     
    procedure Replace(var Stroka: GrfLine;
      OldChar: Char;
      Repl: string);
    var
      I, J: Word;
    begin
      if (GrafLength = 0) or (Length(Repl) = 0) then
        Exit;
      I := 1;
      while I <= GrafLength do
      begin
        if Chr(Stroka[I]) = OldChar then
        begin
          for J := GrafLength downto I + 1 do
            Stroka[J + Length(Repl) - 1] := Stroka[J];
          for J := 1 to Length(Repl) do
            Stroka[I + J - 1] := Ord(Repl[J]);
          I := I + J;
          GrafLength := GrafLength + Length(Repl) - 1;
          continue
        end;
        I := I + 1
      end
    end;
     
    procedure PushCoord(var Ptr: PointPtr;
     
      C: Point);
    var
     
      P: PointPtr;
    begin
     
      New(P);
      P^.X := C.X;
      P^.Y := C.Y;
      P^.Angle := C.Angle;
      P^.Next := Ptr;
      Ptr := P
    end;
     
    procedure PopCoord(var Ptr: PointPtr;
     
      var Res: Point);
    begin
     
      if Ptr <> nil then
      begin
        Res.X := Ptr^.X;
        Res.Y := Ptr^.Y;
        Res.Angle := Ptr^.Angle;
        Ptr := Ptr^.Next
      end
    end;
     
    procedure FindGrafCoord(var Dx, Dy: Word;
     
      Angle: Real;
      StepLength: Word);
    begin
     
      Dx := Round(Sin(Angle) * StepLength * GetMaxX / GetMaxY);
      Dy := Round(-Cos(Angle) * StepLength);
    end;
     
    procedure NewAngle(Way: ShortInt;
     
      var Angle: Real;
      AngleStep: Real);
    begin
     
      if Way >= 0 then
        Angle := Angle + AngleStep
      else
        Angle := Angle - AngleStep;
      if Angle >= 4 * Pi then
        Angle := Angle - 4 * Pi;
      if Angle < 0 then
        Angle := 4 * Pi + Angle
    end;
     
    procedure Rost(var Descr: GrfLine;
     
      Cn: Byte;
      Ch: ChangeType);
    var
      I: Byte;
    begin
     
      for I := 1 to Cn do
        Replace(Descr, Ch[I].Mean, Ch[I].NewString);
    end;
     
    procedure Init1;
    begin
     
      AngleStep := Pi / 8;
      StepLength := 7;
      Generation := 4;
      ChangeNumber := 1;
      CurPosition.Next := nil;
      StartLine := 'F';
      GrafLength := Length(StartLine);
      with Changes[1] do
      begin
        Mean := 'F';
        NewString := 'FF+[+F-F-F]-[-F+F+F]'
      end;
    end;
     
    procedure Init2;
    begin
     
      AngleStep := Pi / 4;
      StepLength := 3;
      Generation := 5;
      ChangeNumber := 2;
      CurPosition.Next := nil;
      StartLine := 'G';
      GrafLength := Length(StartLine);
      with Changes[1] do
      begin
        Mean := 'G';
        NewString := 'GFX[+G][-G]'
      end;
      with Changes[2] do
      begin
        Mean := 'X';
        NewString := 'X[-FFF][+FFF]FX'
      end;
    end;
     
    procedure Init3;
    begin
     
      AngleStep := Pi / 10;
      StepLength := 9;
      Generation := 5;
      ChangeNumber := 5;
      CurPosition.Next := nil;
      StartLine := 'SLFF';
      GrafLength := Length(StartLine);
      with Changes[1] do
      begin
        Mean := 'S';
        NewString := '[+++G][---G]TS'
      end;
      with Changes[2] do
      begin
        Mean := 'G';
        NewString := '+H[-G]L'
      end;
      with Changes[3] do
      begin
        Mean := 'H';
        NewString := '-G[+H]L'
      end;
      with Changes[4] do
      begin
        Mean := 'T';
        NewString := 'TL'
      end;
      with Changes[5] do
      begin
        Mean := 'L';
        NewString := '[-FFF][+FFF]F'
      end;
    end;
     
    begin
     
      case GrafType of
        1: Init1;
        2: Init2;
        3: Init3;
      else
      end;
      grDriver := detect;
      InitGraph(grDriver, grMode, '');
      ErrCode := GraphResult;
      if ErrCode <> grOk then
      begin
        WriteLn('Graphics error:', GraphErrorMsg(ErrCode));
        Halt(1)
      end;
      with CurPosition do
      begin
        X := GetMaxX div 2;
        Y := GetMaxY;
        Angle := 0;
        MoveTo(X, Y)
      end;
      SetColor(white);
      for K := 1 to Generation do
      begin
        Rost(Descript, ChangeNumber, Changes);
        Mark(Mem);
        for T := 1 to GrafLength do
        begin
          case Chr(Descript[T]) of
            'F':
              begin
                FindGrafCoord(Dx, Dy, CurPosition.Angle, StepLength);
                with CurPosition do
                begin
                  Xt := X + Dx;
                  if Xt < 0 then
                    X := 0
                  else
                    X := Xt;
                  if X > GetMaxX then
                    X := GetMaxX;
                  Xt := Y + Dy;
                  if Xt < 0 then
                    Y := 0
                  else
                    Y := Xt;
                  if Y > GetMaxY then
                    Y := GetMaxY;
                  LineTo(X, Y)
                end
              end;
            'f':
              begin
                FindGrafCoord(Dx, Dy, CurPosition.Angle, StepLength);
                with CurPosition do
                begin
                  Xt := X + Dx;
                  if Xt < 0 then
                    X := 0
                  else
                    X := Xt;
                  if X > GetMaxX then
                    X := GetMaxX;
                  Xt := Y + Dy;
                  if Xt < 0 then
                    Y := 0
                  else
                    Y := Xt;
                  if Y > GetMaxY then
                    Y := GetMaxY;
                  MoveTo(X, Y)
                end
              end;
            '+': NewAngle(1, CurPosition.Angle, AngleStep);
            '-': NewAngle(-1, CurPosition.Angle, AngleStep);
            'I': NewAngle(1, CurPosition.Angle, 2 * Pi);
            '[': PushCoord(CurPosition.Next, CurPosition);
            ']':
              begin
                PopCoord(CurPosition.Next, CurPosition);
                with CurPosition do
                  MoveTo(X, Y)
              end
          end
        end;
        Dispose(Mem);
        Delay(1000)
      end;
      repeat
      until KeyPressed;
      CloseGraph
    end.

