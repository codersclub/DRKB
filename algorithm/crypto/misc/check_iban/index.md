---
Title: Как проверить правильность International Bank Account Number?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как проверить правильность International Bank Account Number?
=============================================================

    // IBAN = International Bank Account Number 
    // Example : CH10002300A1023502601 
     
    function ChangeAlpha(input: string): string; 
      // A -> 10, B -> 11, C -> 12 ... 
    var  
      a: Char; 
    begin 
      Result := input; 
      for a := 'A' to 'Z' do 
      begin 
        Result := StringReplace(Result, a, IntToStr(Ord(a) - 55), [rfReplaceAll]); 
      end; 
    end; 
     
    function CalculateDigits(iban: string): Integer; 
    var  
      v, l: Integer; 
      alpha: string; 
      number: Longint; 
      rest: Integer; 
    begin 
      iban := UpperCase(iban); 
      if Pos('IBAN', iban) > 0 then 
        Delete(iban, Pos('IBAN', iban), 4); 
      iban := iban + Copy(iban, 1, 4); 
      Delete(iban, 1, 4); 
      iban := ChangeAlpha(iban); 
      v := 1; 
      l := 9; 
      rest := 0; 
      alpha := ''; 
      try 
        while v <= Length(iban) do 
        begin 
          if l > Length(iban) then 
            l := Length(iban); 
          alpha := alpha + Copy(iban, v, l); 
          number := StrToInt(alpha); 
          rest := number mod 97; 
          v := v + l; 
          alpha := IntToStr(rest); 
          l := 9 - Length(alpha); 
        end; 
      except 
        rest := 0; 
      end; 
      Result := rest; 
    end; 
     
    function CheckIBAN(iban: string): Boolean; 
    begin 
      iban := StringReplace(iban, ' ', '', [rfReplaceAll]); 
      if CalculateDigits(iban) = 1 then 
        Result := True 
      else 
        Result := False; 
    end; 

