---
Title: Сохранение и загрузка двумерного динамического масива
Date: 01.01.2007
---


Сохранение и загрузка двумерного динамического масива
=====================================================

::: {.date}
01.01.2007
:::

    type
      T2DBooleanArray = array of array of Boolean;
     
    procedure Save2DBooleanArray(const A: T2DBooleanArray; S: TStream);
    var
      writer: TWriter;
      i: Integer;
    begin
      Assert(Assigned(S));
      writer := TWriter.Create(S, 8096);
      try
        writer.WriteInteger(Length(A));
        for i := 0 to Length(A) - 1 do
        begin
          writer.WriteInteger(Length(A[i]));
          writer.Write(A[i, 0], Length(A[i]) * sizeof(A[i, 0]));
        end; { For }
      finally
        writer.Free;
      end; { Finally }
    end;
     
    procedure Load2DBooleanArray(var A: T2DBooleanArray; S: TStream);
    var
      reader: TReader;
      i, numrows, numcols: Integer;
    begin
      Assert(Assigned(S));
      reader := TReader.Create(S, 8096);
      try
        numrows := reader.ReadInteger;
        SetLength(A, numrows);
        for i := 0 to numrows - 1 do
        begin
          numcols := reader.ReadInteger;
          SetLength(A[i], numcols);
          reader.Read(A[i, 0], numcols * sizeof(A[i, 0]));
        end; { For }
      finally
        reader.Free;
      end; { Finally }
    end;

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
