<h1>Как посчитать логарифм?</h1>
<div class="date">01.01.2007</div>


<pre>
{
 
   --- English ------
   A logarithm function with a variable basis
 
}
 function Log(x, b: Real): Real;
 begin
   Result := ln(x) / ln(b);
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   ShowMessage(Format('%f', [Log(10, 10)]));
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
