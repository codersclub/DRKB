<h1>Вычисление простого хеш-кода для блока данных</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Вычисление простого хеш-кода для блока данных
 
Вычисляет значение простой хеш-функции (xor + циклический сдвиг) для блока 
данных.
 
Описание параметров:
Data - указатель на блок данных
 
DataSize - размер блока
 
Возвращаемое значение - значение хеш-функции
 
Зависимости: нет
Автор:       vuk, vuk@fcenter.ru
Copyright:   Алексей Вуколов
Дата:        18 апреля 2002 г.
********************************************** }
 
function CalcHash(Data : pointer; DataSize : integer) : integer; register;
asm
  push ebx
  push esi
  push edi
  mov esi, Data
  xor ebx, ebx
  or esi, esi
  jz @@Exit
  mov edx, DataSize
  or edx,edx
  jz @@Exit
  xor ecx,ecx
 
@@Cycle:
  xor eax,eax
  mov al,[esi]
  inc esi
  rol eax,cl
  xor ebx,eax
  inc ecx
  dec edx
  jnz @@Cycle
 
@@Exit:
  mov eax,ebx
  pop edi
  pop esi
  pop ebx
end; 
</pre>

<p> Пример использования:</p>
<pre>
//вычисление хеш-кода для строки
 
var
   i : integer;
   s : string;
...
s := 'test';
i := CalcHash(pointer(S), length(S)); 
</pre>

