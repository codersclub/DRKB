<h1>Перечислить все разбиения N на целые положительные слагаемые</h1>
<div class="date">01.01.2007</div>

<p>Пример: N=4, разбиения: 1+1+1+1, 2+1+1, 2+2, 3+1, 4.</p>
First = (1,1,...,1) - N единиц Last = (N)</p>
<p>Чтобы разбиения не повторялись, договоримся перечислять слагаемые в невозрастающем порядке. Сказать, сколько их будет всего, не так-то просто (см.следующий пункт). Для составления алгоритма Next зададимся тем же вопросом: в каком случае i-ый член разбиения можно увеличить, не меняя предыдущих?</p>
<p>Во-первых, должно быть X[i-1]&gt;X[i] или i=1. Во-вторых, i должно быть не последним эле ментом (увеличение i надо компенсировать уменьшением следующих). Если такого i нет, то данное разбиение последнее. Увеличив i, все следующие элементы надо взять минимально возможными, т.е. равными единице:</p>
<pre>
    procedure Next;
      begin
        {найти i: (i&lt;L) and ( (X[i-1]&gt;X[i]) or (i=1) )}
        X[i]:=X[i]+1;
        { L:= i + X[i+1]+...+X[L] - 1 }
        X[i+1]:=...:=X[L]:=1
      end;
</pre>
<p>Через L мы обозначили количество слагаемых в текущем разбиении (понятно, что 1&lt;=L&lt;=N). Программа будет выглядеть так:</p>
<pre>
  program Razbieniya;
    type Razb=array [byte] of byte;
    var N,i,L:byte;
        X:Razb;
    procedure Next(var X:Razb;var L:byte);
      var i,j:byte;
          s:word;
    begin
      i:=L-1;s:=X[L];
      {поиск i}
      while (i&gt;1)and(X[i-1]&lt;=X[i]) do begin s:=s+X[i];dec(i) end;
      inc(X[i]);
      L:=i+s-1;
      for j:=i+1 to L do X[j]:=1
    end;
  begin
    write('N=');readln(N);
    L:=N; for i:=1 to L do X[i]:=1;
    for i:=1 to L do write(X[i]);writeln;
    repeat
      Next(X,L);
      for i:=1 to L do write(X[i]);writeln
    until L=1
  end.
</pre>

<p><a href="https://algolist.manual.ru" target="_blank">https://algolist.manual.ru</a></p>
