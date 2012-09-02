<h1>Обновление вычисляемых полей</h1>
<div class="date">01.01.2007</div>

Обновление вычисляемых полей </p>

<p>&nbsp;<br>
<p>&nbsp;</p>
Автор: OAmiry (Borland) </p>
<p>Разместите строчку типа нижеприведенной в конце кода обработчика события OnCalcFields:</p>
<pre>
{предположим, что вы используете DBGrid1}
if DBGrid1.Showing then
  DBGrid1.Invalidate ;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
