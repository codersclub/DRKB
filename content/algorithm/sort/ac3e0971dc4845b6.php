<h1>Сортировка методом двунаправленного пузырька</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Сортировка различными методами
 
Сортировка одномерного массива значений типа Double методами:
1) Двунаправленный Пузырёк (BiDirBubbleSort);
 
Зависимости: Math
Автор:       iZEN, izen@mail.ru
Copyright:   адаптация для Delphi
Дата:        14 сентября 2004 г.
********************************************** }
 
{ Сортировка Двунаправленным Пузырьком }
procedure BiDirBubbleSort(var data: array of double);
var
  i, j, limit, st: Integer;
  t: double;
  Swapped: Boolean;
begin
  limit := High(data) + 1;
  st := -1;
  while (st &lt; limit)
  do begin
     Inc(st);
     Dec(limit);
     Swapped := False;
     j := st;
     while (j &lt; limit)
     do begin
        if (data[j] &gt; data[j+1])
        then begin
             t := data[j];
             data[j] := data[j+1];
             data[j+1] := t;
             Swapped := True;
             end;
        Inc(j);
        end;
     if (not Swapped)
     then EXIT
     else Swapped := False;
     j := limit - 1;
     repeat
       if (data[j] &gt; data[j+1])
       then begin
            t := data[j];
            data[j] := data[j+1];
            data[j+1] := t;
            Swapped := True;
            end;
       Dec(j);
     until (j &lt; st);
     if (not Swapped) then EXIT;
     end;
end;
</pre>

