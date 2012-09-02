<h1>Как получить дату по Юлианскому календарю?</h1>
<div class="date">01.01.2007</div>



<pre>
function julian(year, month, day: Integer): real;
var
  yr, mth: Integer;
  noleap, leap, days, yrs: Real;
begin
  if year &lt; 0 then yr := year + 1 else yr := year;
  mth := month;
  if (month &lt; 3) then
    begin
      mth := mth + 12;
      yr := yr - 1;
    end;
  yrs := 365.25 * yr;
  if ((yrs &lt; 0) and (frac(yrs) &lt;&gt; 0)) then yrs := int(yrs) - 1 else yrs := int(yrs);
  days := int(yrs) + int(30.6001 * (mth + 1)) + day - 723244.0;
  if days &lt; -145068.0 then julian := days
  else
  begin
    yrs := yr / 100.0;
    if ((yrs &lt; 0) and (frac(yrs) &lt;&gt; 0)) then yrs := int(yrs) - 1;
    noleap := int(yrs);
    yrs := noleap / 4.0;
    if ((yrs &lt; 0) and (frac(yrs) &lt;&gt; 0)) then yrs := int(yrs) - 1;
    leap := 2 - noleap + int(yrs);
    julian := days + leap;
  end;
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
