<h1>Определить, сейчас до или после полудня</h1>
<div class="date">01.01.2007</div>

<pre>
procedure AM_or_PM;
 begin
   if Frac(Time) = 0 then
     ShowMessage('AM')
   else
     ShowMessage('PM');
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
