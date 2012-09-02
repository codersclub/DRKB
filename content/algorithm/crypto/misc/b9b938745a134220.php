<h1>Создание банковского ключа</h1>
<div class="date">01.01.2007</div>


<pre>
function CheckCtrlKey( aNLs : string; aMfo : real ) : boolean;
const
  {12345678901234567890xxx}
  msk : string[28]= '71371371371371371371713';
var
  i : byte;
  s : integer;
  nls : string[28];
  bic : string[10];
begin
  bic := LeftPad( Real0Str( aMfo, 9, 0 ), 9 );
  if bic[7] &lt; &gt;  '0' then {&lt; =Простая проверка -- это РКЦ?}
    { не учитывает ГРКЦ }
    nls := bic[7]+bic[8]+bic[9]
  else
    nls := '0'+ bic[5]+bic[6]; { РКЦ }
  nls := aNLs + nls;
  s:= 0;
  for i := 1 to 23 do
    s := s + ( ( (byte(nls[i])-48) * (byte(msk[i])-48) ) mod 10 );
  s := s mod 10;
  CheckCtrlKey := s = 0;
end;
 
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
