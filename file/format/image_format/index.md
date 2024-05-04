---
Title: Как определить графический формат файла (не используя расширение)?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как определить графический формат файла (не используя расширение)?
==================================================================

Определить это можно и без расширения.
Ниже представлена функция, которая читает заголовок файла и определяет его тип.

    function PhysicalResolveFileType(AStream: TStream): Integer;
    var
      p: PChar;
    begin
      Result := 0;
      if not Assigned(AStream) then
        Exit;
      GetMem(p, 10);
      try
        AStream.Position := 0;
        AStream.Read(p[0], 10);
        {bitmap format}
        if (p[0] = #66) and (p[1] = #77) then
          Result := 1;
        {tiff format}
        if ((p[0] = #73) and (p[1] = #73) and (p[2] = #42) and (p[3] = #0)) or
          ((p[0] = #77) and (p[1] = #77) and (p[2] = #42) and (p[3] = #0)) then
          Result := 2;
        {jpg format}
        if (p[6] = #74) and (p[7] = #70) and (p[8] = #73) and (p[9] = #70) then
          Result := 3;
        {png format}
        if (p[0] = #137) and (p[1] = #80) and (p[2] = #78) and (p[3] = #71) and
          (p[4] = #13) and (p[5] = #10) and (p[6] = #26) and (p[7] = #10) then
          Result := 4;
        {dcx format}
        if (p[0] = #177) and (p[1] = #104) and (p[2] = #222) and (p[3] = #58) then
          Result := 5;
        {pcx format}
        if p[0] = #10 then
          Result := 6;
        {emf format}
        if (p[0] = #215) and (p[1] = #205) and (p[2] = #198) and (p[3] = #154) then
          Result := 7;
        {emf format}
        if (p[0] = #1) and (p[1] = #0) and (p[2] = #0) and (p[3] = #0) then
          Result := 7;
      finally
        Freemem(p);
      end;
    end;

