<h1>Сохранение типа данных множество (TFontStyles)</h1>
<div class="date">01.01.2007</div>


<pre>
{You do that simple by converting it to an integer, and then stores that:}
 
 type
   pFontStyles = ^TFontStyles;
   pInteger = ^integer;
 
 function FontStylesToInteger(const Value : TFontStyles): integer;
 begin
   Result := pInteger(@Value)^;
 end;
 
 function IntegerToFontStyles(const Value : integer): TFontStyles;
 begin
   Result := pFontStyles(@Value)^;
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
