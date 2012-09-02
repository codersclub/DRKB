<h1>Проверка наличия числа в массиве</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Проверка наличия числа в массиве
 
Функция проверяет, находится ли число N в массиве Values
 
Зависимости: нет
Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
Copyright:   Dimka Maslov
Дата:        28 мая 2002 г.
***************************************************** }
 
function Among(N: Integer; const Values: array of Integer): LongBool;
asm
   push ebx
   xor ebx, ebx
@@10:
   test ecx, ecx
   jl @@30
   cmp eax, [edx]
   jne @@20
   not ebx
   jmp @@30
@@20:
   add edx, 4
   dec ecx
   jmp @@10
@@30:
   mov eax, ebx
   pop ebx
end;
Пример использования: 
 
Among(N, [1, 2, 3, 4, 5]) 
 
</pre>

