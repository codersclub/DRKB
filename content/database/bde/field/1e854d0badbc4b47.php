<h1>Обновление вычисляемых полей</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: OAmiry (Borland)</div>

<p>Разместите строчку типа нижеприведенной в конце кода обработчика события OnCalcFields:</p>

<pre class="delphi">
{предположим, что вы используете DBGrid1}
if DBGrid1.Showing then
  DBGrid1.Invalidate ;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
