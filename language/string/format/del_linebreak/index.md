---
Title: Как удалить переносы из строки?
Author: Vit
Date: 01.01.2007
---


Как удалить переносы из строки?
===============================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    function DeleteLineBreaks(const S: string): string;
    var
      Source, SourceEnd: PChar;
    begin
      Source := Pointer(S);
      SourceEnd := Source + Length(S);
      while Source < SourceEnd do
      begin
        case Source^ of
          #10: Source^ := #32;
          #13: Source^ := #32;
        end;
        Inc(Source);
      end;
      Result := S;
    end;

------------------------------------------------------------------------

Вариант 2:

Author: Vit

Можно значительно проще:

    function DeleteLineBreaks(const S: string): string;

     
    begin
      Result := StringReplace(S, #10#13, '',[rfReplaceAll]);
    end;


 

 

 
