---
Title: Рекурсивный поиск с помощью функции pos
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Рекурсивный поиск с помощью функции pos
=======================================

    function PosN(Substring, Mainstring: string; n: Integer): Integer;
     
     { 
    Function PosN get recursive - the N th position of "Substring" in 
    "Mainstring". Does the Mainstring not contain Substrign the result 
    is 0. Works with chars and strings. 
    }
     begin
       if Pos(substring, mainstring) = 0 then
        begin
          posn := 0;
          Exit;
        end
       else
       begin
         if n = 1 then posn := Pos(substring, mainstring)
          else
         begin
           posn := Pos(substring, mainstring) + posn(substring, Copy(mainstring,
             (Pos(substring, mainstring) + 1), Length(mainstring)), n - 1);
         end;
       end;
     end;
     
     //Beispiele / Examples 
     
     i := posn('s', 'swissdelphicenter.ch', 2);
       //  i=4 
     
     
     
     i := posn('x', 'swissdelphicenter.ch', 1);
       //  i=0 
     
     
     i := posn('delphi', 'swissdelphicenter.ch', 1);
       //  i=6 


 
