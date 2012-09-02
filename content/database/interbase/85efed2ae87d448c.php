<h1>Создание UDF для InterBase</h1>
<div class="date">01.01.2007</div>


<pre>
library nikelutils

uses SysUtils, Classes;

function MaxInt(var Int1, Int2: Integer): Integer;
  far cdecl export;
begin
  if (Int1 &gt; Int2) then
 &nbsp;&nbsp; Result := Int1
  else
 &nbsp;&nbsp; Result := Int2;
end;

function MinInt(var Int1, Int2: Integer): Integer;
  far cdecl export;
begin
  if (Int1 &lt; Int2) then
 &nbsp;&nbsp; Result := Int1
  else
 &nbsp;&nbsp; Result := Int2;
end;

exports
  MaxInt;
MinInt;

begin
end.
</pre>

<p>А это пишим в базе: </p>
<pre>
DECLARE EXTERNAL FUNCTION MAXINT INTEGER, INTEGER
RETURNS INTEGER BY VALUE
ENTRY_POINT "MaxInt" MODULE_NAME "nikelutils.dll";

DECLARE EXTERNAL FUNCTION MININT INTEGER, INTEGER
RETURNS INTEGER BY VALUE
ENTRY_POINT "MinInt" MODULE_NAME "nikelutils.dll";
 
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
