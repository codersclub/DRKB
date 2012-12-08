---
Title: String \> WideString
Date: 01.01.2007
---


String \> WideString
====================

::: {.date}
01.01.2007
:::

    {:Converts Ansi string to Unicode string using specified code page.
      @param   s        Ansi string.
      @param   codePage Code page to be used in conversion.
      @returns Converted wide string.
    }
    function StringToWideString(const s: AnsiString; codePage: Word): WideString;
    var
      l: integer;
    begin
      if s = '' then
        Result := ''
      else 
      begin
        l := MultiByteToWideChar(codePage, MB_PRECOMPOSED, PChar(@s[1]), - 1, nil, 0);
        SetLength(Result, l - 1);
        if l > 1 then
          MultiByteToWideChar(CodePage, MB_PRECOMPOSED, PChar(@s[1]),
            - 1, PWideChar(@Result[1]), l - 1);
      end;
    end; { StringToWideString }

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>
