<h1>Сортировка выбором</h1>
<div class="date">01.01.2007</div>

<p>     A[1..N] -  сортируемый массив из n элементов.</p>

<p>     for ( i=1; i&lt;N; i++)</p>
<p>          Hайти наименьший из элементов i..N и поменять его местами с i-м.</p>

<p>     Пример действий для случайного массива A[1..8]</p>

<p>          44  55  12  42  94  18  06  67      исходный массив</p>
<p>     i=1  06| 55  12  42  94  18  44  67       06 &lt;-&gt; 44</p>
<p>     i=2  06  12| 55  42  94  18  44  67       12 &lt;-&gt; 55</p>
<p>     i=3  06  12  18| 42  94  55  44  67       18 &lt;-&gt; 55</p>
<p>     i=4  06  12  18  42| 94  55  44  67       42 &lt;-&gt; 42</p>
<p>     i=5  06  12  18  42  44| 55  94  67       44 &lt;-&gt; 94</p>
<p>     i=6  06  12  18  42  44  55| 94  67       55 &lt;-&gt; 55</p>
<p>     i=7  06  12  18  42  44  55  67| 94       67 &lt;-&gt; 94</p>

<p>       Вертикальной чертой отмечена граница уже отсортированной части</p>
<p>     массива.</p>

<p>     Сортировка выбором - простейший алгоритм, на практике не</p>
<p>   используемый ввиду низкого быстродействия. Вместо этого</p>
<p>   применяют ее улучшение - пирамидальную сортировку (Heapsort),</p>
<p>   описанную в другом вопросе, а также (иногда) 'древесную сортировку'</p>
<p>   (TreeSort).</p>

<p>        Пример на Паскале - Hиколас Вирт.</p>
<pre>
 { Сортируются записи типа item по ключу item.key }
 { для вспомогательных переменных используется тип index }
 
 procedure SelectSort;
     var i, j, k: index; x:item;
 begin for i:=1 to n-1 do
     begin k:=i; x:=a[i];
             for j:=i+1 to n do
                     if a[j].key &lt; x.key then
                         begin k:=j; x:=a[j];
                         end;
                 a[k]:=a[i]; a[i]:=x;
         end;
 end;
</pre>


<p>https://algolist.manual.ru</p>
   &copy;Drkb::04155</p>
<hr />
<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Сортировка различными методами
 
Сортировка одномерного массива значений типа Double методами:
2) Выбора (SelectionSort);
 
Зависимости: Math
Автор:       iZEN, izen@mail.ru
Copyright:   адаптация для Delphi
Дата:        14 сентября 2004 г.
********************************************** }
 
 
{ Сортировка SelectionSort }
procedure SelectionSort(var data: array of double);
var
  lo, hi, i, j: Integer;
  t: double;
begin
  lo := Low(data);
  hi := High(data);
  for i := lo to hi do
    for j := hi downto i + 1 do
      if data[i] &gt; data[j] then
      begin
        t := data[i];
        data[i] := data[j];
        data[j] := t;
      end;
end;
 
</pre>


