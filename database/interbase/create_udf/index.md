---
Title: Создание UDF для InterBase
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Создание UDF для InterBase
==========================

    library nikelutils

    uses SysUtils, Classes;

    function MaxInt(var Int1, Int2: Integer): Integer;
      far cdecl export;
    begin
      if (Int1 > Int2) then
        Result := Int1
      else
        Result := Int2;
    end;

    function MinInt(var Int1, Int2: Integer): Integer;
      far cdecl export;
    begin
      if (Int1 < Int2) then
        Result := Int1
      else
        Result := Int2;
    end;

    exports
      MaxInt;
    MinInt;

    begin
    end.

А это пишем в базе:

    DECLARE EXTERNAL FUNCTION MAXINT INTEGER, INTEGER
    RETURNS INTEGER BY VALUE
    ENTRY_POINT "MaxInt" MODULE_NAME "nikelutils.dll";

    DECLARE EXTERNAL FUNCTION MININT INTEGER, INTEGER
    RETURNS INTEGER BY VALUE
    ENTRY_POINT "MinInt" MODULE_NAME "nikelutils.dll";

