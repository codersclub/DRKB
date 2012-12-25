---
Title: Bin \> Dec
Author: Yanis
Date: 01.01.2007
---


Bin \> Dec
==========

::: {.date}
01.01.2007
:::

    function BinToInt(const Value: string): Integer;

    var
      i, strLen: Integer;
    begin
      Result := 0;
      strLen := Length(Value);
      for i := 1 to strLen do
        if Value[i] = '1' then
          Result := Result or (1 shl (strLen - i))
        else
          Result := Result and not (1 shl (strLen - i));
    end;
     

Автор: Yanis

Взято с Vingrad.ru <https://forum.vingrad.ru>
