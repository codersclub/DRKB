<h1>Получение значения бита в двойном слове</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Получение значения бита в двойном слове
 
Функция возвращает значение бита с номером Index в двойном слове Value
 
Зависимости: нет
Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
Copyright:   Dimka Maslov
Дата:        21 мая 2002 г.
***************************************************** }
 
function Bit(Value, Index: Integer): Boolean;
asm
   bt eax, edx
   setc al
   and eax, 0FFh
end;
</pre>

