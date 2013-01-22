---
Title: WideString -> String
Date: 01.01.2007
---


WideString -> String
====================

::: {.date}
01.01.2007
:::

    {:Converts Unicode string to Ansi string using specified code page.
      @param   ws       Unicode string.
      @param   codePage Code page to be used in conversion.
      @returns Converted ansi string.
    }
     
    function WideStringToString(const ws: WideString; codePage: Word): AnsiString;
    var
      l: integer;
    begin
      if ws = '' then
        Result := ''  else 
      begin
        l := WideCharToMultiByte(codePage,
          WC_COMPOSITECHECK or WC_DISCARDNS or WC_SEPCHARS or WC_DEFAULTCHAR,
          @ws[1], - 1, nil, 0, nil, nil);
        SetLength(Result, l - 1);
        if l > 1 then
          WideCharToMultiByte(codePage,
            WC_COMPOSITECHECK or WC_DISCARDNS or WC_SEPCHARS or WC_DEFAULTCHAR,
            @ws[1], - 1, @Result[1], l - 1, nil, nil);
      end;
    end; { WideStringToString }

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

------------------------------------------------------------------------
