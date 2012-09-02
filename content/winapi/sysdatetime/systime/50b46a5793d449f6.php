<h1>Проверить, используется ли формат времени в 24 часа</h1>
<div class="date">01.01.2007</div>


<pre>
function Is24HourTimeFormat: Boolean;
 var
   DefaultLCID: LCID;
 begin
   DefaultLCID := GetThreadLocale;
   Result := 0 &lt;&gt; StrToIntDef(GetLocaleStr(DefaultLCID,
     LOCALE_ITIME,'0'), 0);
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
