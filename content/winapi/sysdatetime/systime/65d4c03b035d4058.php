<h1>Определение текущего времени (часы, минуты и секунды)</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Определение текущего времени(часы, минуты, секунды)
 
Зависимости: SysUtils, Classes
Автор:       Eagle, ICQ:160702560
Copyright:   MegaSoft
Дата:        2 ноября 2002 г.
***************************************************** }
 
unit gettime;
 
interface
uses SysUtils, Classes;
 
function gethours: integer;
function getmins: integer;
function getsecs: integer;
 
implementation
 
function gethours: integer;
var
  s: string;
  h: integer;
begin
  s := timetostr(time);
  h := strtoint(s[1] + s[2]);
  Result := h;
end;
 
function getmins: integer;
var
  s: string;
  h: integer;
begin
  s := timetostr(time);
  h := strtoint(s[4] + s[5]);
  Result := h;
end;
 
function getsecs: integer;
var
  s: string;
  h: integer;
begin
  s := timetostr(time);
  h := strtoint(s[7] + s[8]);
  Result := h;
end;
 
end.
</pre>

