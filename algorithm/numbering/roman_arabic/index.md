---
Title: Конвертация римских цифр в арабские
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Конвертация римских цифр в арабские
===================================

    function RomanToDec(const Value: string): integer;
    var
      i, lastValue, curValue: integer;
    begin
      Result := 0;
      lastValue := 0;
      for i := Length(Value) downto 1 do
      begin
        case UpCase(Value[i]) of
          'C':
            curValue := 100;
          'D':
            curValue := 500;
          'I':
            curValue := 1;
          'L':
            curValue := 50;
          'M':
            curValue := 1000;
          'V':
            curValue := 5;
          'X':
            curValue := 10;
        else
          raise Exception.CreateFmt('Invalid character: %s', [Value[i]]);
        end;
        if curValue < lastValue then
          Dec(Result, curValue)
        else
          Inc(Result, curValue);
        lastValue := curValue;
      end;
    end;

