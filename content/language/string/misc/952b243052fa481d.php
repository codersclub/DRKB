<h1>Проверка значения строки</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Проверка значения строки
 
Функция предназначена дла проверки значения строки.
 
Зависимости: нет
Автор:       Separator, vilgelm@mail.kz, Алматы
Copyright:   Сергей Вильгельм
Дата:        6 января 2003 г.
***************************************************** }
 
type
  TTypeStr = (tsString, tsDate, tsNumber);
 
function CheckString(const Value: string): TTypeStr;
begin
  if StrToDateTimeDef(Value, 0) = 0 then
    if StrToIntDef(Value, 0) = 0 then
      Result := tsString
    else
      Result := tsNumber
  else
    Result := tsDate
end;
</pre>
</p>
