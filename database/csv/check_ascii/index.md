---
Title: Как определить, имеет ли файл ASCII-формат
Author: http://www.swissdelphicenter.ch
Date: 01.01.2007
Source: http://www.swissdelphicenter.ch
---


Как определить, имеет ли файл ASCII-формат
==========================================

    function isAscii(NomeFile: string): Boolean;
     const
       SETT = 2048;
     var
       i: Integer;
       F: file;
       a: Boolean;
       TotSize, IncSize, ReadSize: Integer;
       c: array[0..Sett] of Byte;
     begin
       if FileExists(NomeFile) then
       begin
         {$I-}
         AssignFile(F, NomeFile);
         Reset(F, 1);
         TotSize := FileSize(F);
         IncSize := 0;
         a       := True;
         while (IncSize < TotSize) and (a = True) do
         begin
           ReadSize := SETT;
           if IncSize + ReadSize > TotSize then ReadSize := TotSize - IncSize;
           IncSize := IncSize + ReadSize;
           BlockRead(F, c, ReadSize);
           // Iterate 
          for i := 0 to ReadSize - 1 do
             if (c[i] < 32) and (not (c[i] in [9, 10, 13, 26])) then a := False;
         end; { while }
         CloseFile(F);
         {$I+}
         if IOResult <> 0 then Result := False
         else
            Result := a;
       end;
     end;
     
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       if OpenDialog1.Execute then
         if isAscii(OpenDialog1.FileName) then
           ShowMessage('ASCII File');
     end;

