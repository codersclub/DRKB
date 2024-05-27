---
Title: Использовать TTime для более 24 часов
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Использовать TTime для более 24 часов
=====================================

    function TextToTime(S: string): Integer;
     var
       p, i: Integer;
       Sh, Sm, Ss: string;
     begin
       Sh := '';
       SM := '';
       SS := '';
       i  := 1;
       p  := 0;
       while i do
       begin
         if (s[i] <> ':') then
         begin
           case P of
             0: SH := Sh + s[i];
             1: SM := SM + S[i];
             2: SS := SS + S[i];
           end;
         end
         else
           Inc(p);
         Inc(i);
       end;
       try
         Result := (StrToInt(SH) * 3600) + (StrToInt(SM) * 60) + (StrToInt(SS))
         except
           Result := 0;
       end;
     end;
     
     function TimeToText(T: Integer): string;
     var
       H, M, S: string;
       ZH, ZM, ZS: Integer;
     begin
       ZH := T div 3600;
       ZM := T div 60 - ZH * 60;
       ZS := T - (ZH * 3600 + ZM * 60);
       if ZH then H := '0' + IntToStr(ZH)
       else
         H := IntToStr(ZH);
       if ZM then M := '0' + IntToStr(ZM)
       else
         M := IntToStr(ZM);
       if ZS then S := '0' + IntToStr(ZS)
       else
         S := IntToStr(ZS);
       Result := H + ':' + M + ':' + S;
     end;

