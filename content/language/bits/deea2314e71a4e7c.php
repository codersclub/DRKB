<h1>Как работать с битами?</h1>
<div class="date">01.01.2007</div>

<p>Есть два способа. </p>
<p>Низкоуровневый подход обеспечивается логическими операциями : </p>
<pre>
var
  I : integer;
  N : integer;                       // Номер бита в диапазоне от 0..SizeOf(TYPE)*8 - 1
begin
  I := I or (1 shl N);               // установка бита
  I := I and not (1 shl N);          // сброс бита
  I := I xor (1 shl N);              // инверсия бита
  if (i and (1 shl N)) &lt;&gt; 0 then...  // проверка установленного бита
end;
</pre>
<p>Высокоуровневый подход опирается на представление числа в виде множества: </p>
<pre>
type
  TIntegerSet = set of 0..SizeOf(Integer)*8 - 1;
var
  I : Integer;
  N : Integer;
begin
  Include(TIntegerSet(I), N);     // установили N-ный бит в 1
  Exclude(TIntegerSet(I), N);     // сбросили N-ный бит в 0
  if N in TIntegerSet(I) then...  // проверили N-ный бит
end;
 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

