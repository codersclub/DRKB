---
Title: Получить многострочные значения из реестра и преобразовать их в TStringList
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Получить многострочные значения из реестра и преобразовать их в TStringList
===========================================================================

    function ReadMultirowKey(reg: TRegistry; Key: string): TStrings;
    const
      bufsize = 100;
    var
      i: integer;
      s1: string;
      sl: TStringList;
      bin: array[1..bufsize] of char;
    begin
      try
        result := nil;
        sl := nil;
        sl := TStringList.Create;
        if not Assigned(reg) then
          raise Exception.Create('TRegistry object not assigned.');
        FillChar(bin, bufsize, #0);
        reg.ReadBinaryData(Key, bin, bufsize);
        i := 1;
        s1 := '';
        while i < bufsize do
        begin
          if ord(bin[i]) >= 32 then
            s1 := s1 + bin[i]
          else
          begin
            if Length(s1) > 0 then
            begin
              sl.Add(s1);
              s1 := '';
            end;
          end;
          inc(i);
        end;
        result := sl;
      except
        sl.Free;
        raise;
      end;
    end;

