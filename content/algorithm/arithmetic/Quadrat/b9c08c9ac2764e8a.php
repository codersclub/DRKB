<h1>Вычисление квадратного корня (алгоритм Ньютона)</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Вычисление квадратного корня (алгоритм Ньютона)
 
Зависимости: нет
Автор:       Fenik, chook_nu@uraltc.ru, Новоуральск
Copyright:   Автор: Федоровских Николай
Дата:        20 апреля 2003 г.
********************************************** }
 
function MySqrt(x: Double; n: Byte): Double;
{ x - аргумент
  n - точность вычисления (советую брать 7-8) }
var i: Integer;
begin
  if x &lt;= 0 then begin
    Result := 0;
    Exit;
  end
  else Result := 4;
  for i := 0 to n do begin
    Result := (Result + x/Result)/2;
  end;
end; 
</pre>

<p> Пример использования:</p>
<pre>
procedure TForm1.FormCreate(Sender: TObject);
var n: Double;
begin
  //Тест (сверить с калькулятором)
  n := 29.7665342;
  Caption := 'Sqrt(' + FloatToStrF(n, ffFixed, 10, 5) + ') = ' +
                       FloatToStrF(MySqrt(n, 7), ffFixed, 10, 10);
end; 
</pre>

