---
Title: Несколько расширенных функций по определению позиции
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Несколько расширенных функций по определению позиции
====================================================

    // Get the Position of a string, starting at the end 
    // Ruckwartiges Vorkommen einer Zeichenkette innerhalb eines strings, Position von hinten 
     
    function LastPos(SearchStr, Str: string): Integer;
    var
      i: Integer;
      TempStr: string;
    begin
      Result := Pos(SearchStr, Str);
      if Result = 0 then Exit;
      if (Length(Str) > 0) and (Length(SearchStr) > 0) then
      begin
        for i := Length(Str) + Length(SearchStr) - 1 downto Result do
        begin
          TempStr := Copy(Str, i, Length(Str));
          if Pos(SearchStr, TempStr) > 0 then
          begin
            Result := i;
            break;
          end;
        end;
      end;
    end;
    
    // Search for the next occurence of a string from a certain Position 
    // Nachstes Vorkommen einer Zeichenkette ab einer frei definierbaren Stelle im string 
     
    function NextPos(SearchStr, Str: string; Position: Integer): Integer;
    begin
      Delete(Str, 1, Position - 1);
      Result := Pos(SearchStr, upperCase(Str));
      if Result = 0 then Exit;
      if (Length(Str) > 0) and (Length(SearchStr) > 0) then
        Result := Result + Position + 1;
    end;
    
    // Get the number of characters from a certain Position to the string to be searched 
    // Anzahl der Zeichen von einer definierbaren Position zur gesuchten Zeichenkette 
     
    function NextPosRel(SearchStr, Str: string; Position: Integer): Integer;
    begin
      Delete(Str, 1, Position - 1);
      Result := Pos(SearchStr, UpperCase(Str)) - 1;
    end;
    
    // simple replacement for strings 
    // einfaches Ersetzen von Zeichenketten 
     
    function ReplaceStr(Str, SearchStr, ReplaceStr: string): string;
    begin
      while Pos(SearchStr, Str) <> 0 do
      begin
        Insert(ReplaceStr, Str, Pos(SearchStr, Str));
        Delete(Str, Pos(SearchStr, Str), Length(SearchStr));
      end;
      Result := Str;
    end;

