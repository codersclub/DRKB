---
Title: Как определить реальный размер поля типа BLOB, которое сохранено в таблице?
Date: 01.01.2007
---


Как определить реальный размер поля типа BLOB, которое сохранено в таблице?
===========================================================================

::: {.date}
01.01.2007
:::

Ниже приведена функция GetBlobSize, которая возвращает размер данного
BLOB или MEMO поля.

Пример вызова:

    function GetBlobSize(Field: TBlobField): Longint;
    begin
      with TBlobStream.Create(Field, bmRead) do
      try
        Result := Seek(0, 2);
      finally
        Free;
      end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
     { This sets the Edit1 edit box to display the size of }
     { a memo field named Notes.                           }
     
      Edit1.Text := IntToStr(GetBlobSize(Notes));
    end;

Copyright © 1996 Epsylon Technologies

Взято из FAQ Epsylon Technologies (095)-913-5608; (095)-913-2934;
(095)-535-5349
