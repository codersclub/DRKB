---
Title: Hапечатать все перестановки чисел 1...N
Date: 01.01.2007
---


Hапечатать все перестановки чисел 1...N
========================================

::: {.date}
01.01.2007
:::

First = (1,2,...,N)

Last = (N,N-1,...,1)

Всего таких перестановок будет N!=N*(N-1)*...*2*1 (докажите!). Для
составления алгоритма Next зададимся вопросом: в каком случае i-ый член
перестановки можно увеличить, не меняя предыдущих? Ответ: если он меньше
какого-либо из следующих членов (членов с номерами больше i).

Мы должны найти наибольшее i, при котором это так, т.е. такое i, что
X\[i\]\<X\[i+1\]\>...\>X\[N\] (если такого i нет, то перестановка
последняя). После этого X\[i\] нужно увеличить минимально возможным
способом, т.е. найти среди X\[i+1\],...,X\[N\] наименьшее число,
большее его. Поменяв X\[i\] с ним, остается расположить числа с номерами
i+1,...,N так, чтобы перестановка была наименьшей, то есть в
возрастающем порядке. Это облегчается тем, что они уже расположены в
убывающем порядке:

               procedure Next;
               begin
                 {найти i: X[i]<X[i+1]>X[i+2]>...>X[N]};
                 {найти j: X[j]>X[i]>X[j+1]>...>X[N]};
                 {обменять X[i] и X[j]};
                 {X[i+1]>X[i+2]>...>X[N]};
                 {перевернуть X[i+1],X[i+2],...,X[N]};
               end;

Теперь можно написать программу:

        program Perestanovki;
          type Pere=array [byte] of byte;
          var N,i,j:byte;
              X:Pere;
              Yes:boolean;
          procedure Next(var X:Pere;var Yes:boolean);
            var i:byte;
            procedure Swap(var a,b:byte);  {обмен переменных}
              var c:byte;
            begin c:=a;a:=b;b:=c end;
          begin
            i:=N-1;
            {поиск i}
            while (i>0)and(X[i]>X[i+1]) do dec(i);
            if i>0 then
              begin
                j:=i+1;
                {поиск j}
                while (j<N)and(X[j+1]>X[i]) do inc(j);
                Swap(X[i],X[j]);
                for j:=i+1 to (N+i) div 2 do Swap(X[j],X[N-j+i+1]);
                Yes:=true
              end
            else Yes:=false
          end;
        begin
          write('N=');readln(N);
          for i:=1 to N do X[i]:=i;
          repeat
            for i:=1 to N do write(X[i]);writeln;
            Next(X,Yes)
          until not Yes
        end.


Решение через рекурсию

 

Опишем рекурсивную процедуру Generate(k), предъявляющую все перестановки
чисел 1,...,N, у которых фиксировано начало X\[1\],X\[2\],...,X\[k\].
После выхода из процедуры массив X будут иметь то же значение, что перед
входом (это существенно!). Понятно, что при k=N мы снова имеем только
тривиальное решение - саму перестановку. При k\<N будем сводить задачу к
k+1:

              procedure Generate(k:byte);
                var i,j:byte;
                procedure Swap(var a,b:byte);
                  var c:byte;
                begin c:=a;a:=b;b:=c end;
              begin
                if k=N then
                  begin for i:=1 to N do write(X[i]);writeln end
                else
                  for j:=k+1 to N do
                    begin
                      Swap(X[k+1],X[j]);
                      Generate(k+1);
                      Swap(X[k+1],X[j])
                    end
              end;

Основная программа:

            program PerestanovkiRecursion;
              type Pere=array [byte] of byte;
              var N,i,j:byte;
                  X:Pere;
              procedure Generate(k:byte);
                  ...............
            begin
              write('N=');readln(N);
              for i:=1 to N do X[i]:=i;
              Generate(0)
            end.

Чтобы до конца разобраться в этой непростой программе, советуем
выполнить ее на бумаге при N=3. Обратите внимание, что порядок вывода
перестановок не будет лексикографическим!

<https://algolist.manual.ru>
