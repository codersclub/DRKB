<h1>Повтор строки заданное количество раз</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Повтор строки заданное количество раз
 
Input - строка для повторения
Rep - количество повторений
 
Строка на выходе это входная строка повторенная Rep раз.
 
Зависимости: Стандартные модули
Автор:       Ru, DiVo_Ru@rambler.ru, Одесса
Copyright:   DiVo 2002 creator Ru (по мотивам функции Str из Word Basic)
Дата:        18 ноября 2002 г.
***************************************************** }
 
function MulStr(Input: string; Rep: integer): string;
var
  i: integer;
begin
  for i := 0 to Rep - 1 do
    result := result + Input;
end;
Пример использования: 
 
s1 := 'Привет';
s := MulStr(s1, 3);
 
// результат:
s := 'ПриветПриветПривет';
</pre>

