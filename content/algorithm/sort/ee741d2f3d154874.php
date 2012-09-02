<h1>Компактный код для сортировки массива</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Компактный код для сортировки массива.
 
Очень небольшой код для сортировки массива. Состоит из двух циклов for.
Сортирует от болшего к меньшему.
 
Зависимости: нет
Автор:       Михон
Copyright:   (&lt;Михон&gt;) (с)
Дата:        14 января 2007 г.
********************************************** }
 
for i:= 1 to 5 do begin //отвечает за место старта проверки
    for j:= i to 5 do begin //сам цикл поверки
      if (x[j]) &gt; (x[i]) then begin //если следующеее число больше i,то
        a:= x[j]; //
        x[j]:= x[i]; //меняем местами
        x[i]:= a; //
      end;
    end;
  end; 
</pre>

<p> Пример использования:</p>
<pre>
var
  x: array [1..5] of integer;
  a,k,i,j: integer;
 
 
begin
  writeln ('Vvedite massiv!!!');
  for k:= 1 to 4 do begin //вводим массив
    read (x[k]); //--,--
  end; //--,--
  readln (x[5]); //--,--
  for i:= 1 to 5 do begin //отвечает за место старта проверки
    for j:= i to 5 do begin //сам цикл поверки
      if (x[j]) &gt; (x[i]) then begin //если следующеее число больше i,то
        a:= x[j]; //
        x[j]:= x[i]; //меняем местами
        x[i]:= a; //
      end;
    end;
  end;
  for k:= 1 to 4 do begin //
    write (x[k],' '); //
  end; // выводим массив
  writeln (x[5]); //
  readln; // 
end. 
</pre>

