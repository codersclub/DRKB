<h1>Алгоритм расчета контрольного числа страхового номера ПФ</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Алгоритм расчета контрольного числа страхового номера ПФ
 
Зависимости: System, Sysutils
Автор:       Камбалов А.Н., ACampball@mail.ru, Вологда
Copyright:   Камбалов А.Н.
Дата:        3 июня 2002 г.
********************************************** }
 
// ===========================================
// Алгоритм расчета контрольного числа
// страхового номера ПФ
// ===========================================
function CheckPFCertificate(const PF: string): Boolean;
var
  sum: Word;
  i: Byte;
begin
  Result := False;
  sum := 0;
  if Length(PF) &lt;&gt; 11 then Exit;
 
  try
    for i:=1 to 9 do
      sum := sum + StrToInt(PF[i])*(9-i+1);
    sum := sum mod 101;
    Result := StrToInt(Copy(PF, 10, 2)) = sum;
  except
    Result := False;
  end; // try
end;
</pre>

