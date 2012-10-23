<h1>Увеличение значения указателя</h1>
<div class="date">08.06.2003</div>


<pre>
{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Увеличение значения указателя
 
Конвертирует указатель в Cardinal, увеличиваем значение адреса,
и конвертирует обратно в указатель, который и возвращает.
Внимание, функция не выделяет никаких блоков памяти,
она просто работает с указателем.
 
Зависимости: System
Автор:       Григорий Ситнин, gregor@gregor.ru, Москва
Copyright:   Григорий Ситнин, 2003
Дата:        8 июля 2003 г.
***************************************************** }
 
function IncPtr(APointer: pointer; AHowMuch: cardinal = 1): pointer;
begin
  //*** Конвертируем указатель в Cardinal, увеличиваем значение адреса,
  //*** и конвертируем обратно в указатель, который и возвращаем.
  //**! Внимание, функция не выделяет никаких блоков памяти,
  //**! она просто работает с указателем.
  Result := Ptr(cardinal(APointer) + AHowMuch);
end;
Пример использования: 
 
{$APPTYPE CONSOLE}
program testptr;
uses SysUtils, uIncPtr; //*** Модуль uIncPtr содержит функцию IncPtr
var
  ptr1, ptr2: pointer;
begin
  ptr1 := AllocMem(255);
  ptr2 := incptr(ptr1, 10);
  writeln('ptr1 : ', cardinal(ptr1));
  //*** Напечатать увеличенный на 10 указатель ptr1
  writeln('ptr2 (+10): ', cardinal(ptr2));
  FreeMem(ptr1, 255)
end.
</pre>

&nbsp;</p>
<div class="author">Автор: Григорий Ситнин, gregor@gregor.ru, Москва</div>
