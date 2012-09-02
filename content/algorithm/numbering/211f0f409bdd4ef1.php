<h1>Перевод чисел из десятичной в любую другую систему счисления</h1>
<div class="date">01.01.2007</div>


<pre>
{ Фунция представляет число Value в Base-ричной системе счисления,
  Base должно находиться в пределах [1..36] и представляется
  10-ю цифрами [0..9] и 26-ю буквами английского алфавита ['A'..'Z'] }
function Dec2X(const Value, Base: Cardinal): string;
 
  // Функция возвращает символ, соответствующий числу в N-ричной системе
  function GetChar(const N: Cardinal): Char;
  begin
    if N &lt; 10 then
      // для систем счисления от 1 до 10
      Result := Char(N + Ord('0'))
    else
      // для систем счисления выше 10, но не больше 36 ([0..9] + ['A'..'Z'])
      Result := Char(N - 10 + Ord('A'));
  end;
 
var
  V, R: Cardinal;
begin
  Result := '';
 
  if Base &lt;= 1 then
  begin
    // числа можно и в системе, состоящей из одного символа, представлять ;)
    if Base = 1 then
    begin
      // реализуем это
      SetLength(Result, Value);
      FillChar(Result[1], Value, Ord('0'));
      Exit;
    end else
      // а вот других систем счисления быть не может
      raise EConvertError.Create('Основание системы счисления должно быть больше 0');
  end else
    // ограничиваем представление систем счисления 10-ю цифрами и 26-ю буквами
    // английского алфавита
    if Base &gt; 10 + (Ord('Z') + 1) - Ord('A') then
      raise EConvertError.Create('Основание системы счисления должно лежать в пределах от 1 до 36');
 
  // Выполняем преобразование в нужную систему виртуальным делением в столбик
  V := Value;
  repeat
    R := V mod Base;
    V := V div Base;
    Result := GetChar(R) + Result;
  until V &lt; 2; // 2 - минимальная база,
               // то есть в любом случае когда-то "V div Base" будет равно 1
  if V &lt;&gt; 0 then Result := IntToStr(V) + Result;
end;
</pre>
&copy;Drkb::04060<br>
<p class="author">Автор: s-mike </p>
