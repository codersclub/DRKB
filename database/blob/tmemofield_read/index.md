---
Title: Извлечение текста из TMemoField
Author: Steve Schafer
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Извлечение текста из TMemoField
===============================

    var
      P: PChar;
      S: TMemoryStream;
      Size: LongInt;
    begin
      S := TMemoryStream.Create;
      MyMemoField.SaveToStream(S);
      Size := S.Position;
      GetMem(P, Size + 1);
      S.Position := 0;
      S.Read(P^, Size);
      P[Size] := #0;
      S.Free;
      { используем текст в PChar }
      FreeMem(P, Size + 1);
    end;

