---
Title: Как заменить строку в матрице?
Date: 01.01.2007
Source: <https://www.lmc-mediaagentur.de/dpool>
---


Как заменить строку в матрице?
==============================

    program Matrices;
     
    {$APPTYPE CONSOLE}
     
    uses
      SysUtils;
     
    type
      TMatrixRow = Array of Double;  {preferrable to Real}
      TMatrix = Array of TMatrixRow;
     
     
    procedure MatrixExchangeRows(M: TMatrix; First, Second: Integer);
    var
      Help: TMatrixRow;
    begin
      if (First < 0) or (First > High(M)) or (Second < 0) or (Second > High(M)) then
        Exit;  {or whatever you like.}
      {Only pointers are exchanged!}
      Help := M[First];
      M[First] := M[Second];
      M[Second] := Help;
    end;
     
     
    procedure MatrixWrite(M: TMatrix);
    var
      Row, Col: Integer;
    begin
      for Row := 0 to High(M) do
      begin
        for Col := 0 to High(M[Row]) do
          Write(M[Row, Col]:10:2);
        Writeln;
      end;
      Writeln;
    end;
     
    var
      Matrix: TMatrix;
      Row, Column: Integer;
     
    begin
      Randomize;
      SetLength(Matrix, 4, 4);
      for Row := 0 to High(Matrix) do
        for Column := 0 to High(Matrix[Row]) do
          Matrix[Row, Column] := Random * 1000.0;
      MatrixWrite(Matrix);
      MatrixExchangeRows(Matrix, 1, 2);
      MatrixWrite(Matrix);
      Readln;
    end.

