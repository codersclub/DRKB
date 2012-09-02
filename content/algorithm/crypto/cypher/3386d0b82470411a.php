<h1>Генерация 96-битного ключа для шифрования с помощью Encrypt()</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Генерация 96-битного ключа для шифрования с помощью Encrypt()
 
Генерация 96-битного ключа для шифрования Encrypt()
 
Зависимости: System
Автор:       kronprince, kronprince@mail.ru, ICQ:119018798, Полтава
Copyright:   © kronprince - собственная разработка
Дата:        23 июня 2003 г.
********************************************** }
 
// Генерация 96-битного ключа для шифрования Encrypt()
procedure GenerateKey96(var StartKey, MultKey, AddKey: integer);
var
  i: integer;
  a: array[1..12]of byte;
  procedure FillKey(var VarKey: integer; index: integer);
  var j: integer;
  begin
    for j:= 0 to sizeof(VarKey)-1 do
      VarKey := VarKey or a[index + j] shl (8 * j);
  end;
begin
  System.Randomize();
// Это непосредственно типа случайная генерация :)
  for i:= Low(a) to High(a) do
    a[i] := System.Random(High(byte));
// А тут распихивание по ключевым полям с соответствующей стартовой позиции
  FillKey(StartKey, 1);
  FillKey(MultKey, 5);
  FillKey(AddKey, 9);
end; 
</pre>

<p> Пример использования:</p>
<pre>
GenerateKey96(StartKey, MultKey, AddKey);
Encrypt(S, StartKey, MultKey, AddKey); 
</pre>

