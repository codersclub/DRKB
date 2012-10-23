<h1>Hапечатать все последовательности длины N из чисел 1, 2, ..., M</h1>
<div class="date">01.01.2007</div>

<p>First = (1,1,...,1) Last = (M,M,...,M)</p>
<p>Всего таких последовательностей будет M^N (докажите!). Чтобы понять. как должна действовать процедура Next, начнем с примеров. Пусть N=4,M=3. Тогда:</p>
Next(1,1,1,1) -&gt; (1,1,1,2) Next(1,1,1,3) -&gt; (1,1,2,1) Next(3,1,3,3) -&gt; (3,2,1,1)</p>
<p>Теперь можно написать общую процедуру Next:</p>
<pre>
         procedure Next;
           begin
             {найти i: X[i]&lt;M,X[i+1]=M,...,X[N]=M};
             X[i]:=X[i]+1;
             X[i+1]:=...:=X[N]:=1
           end;
</pre>
<p>Если такого i найти не удается, то следующей последовательности нет - мы добрались до последней (M,M,...,M). Заметим также, что если бы членами последовательности были числа не от 1 до M, а от 0 до M-1, то переход к следующей означал бы прибавление 1 в M-ичной системе счисления. Полная программа на Паскале выглядит так:</p>
<pre>
    program Sequences;
      type Sequence=array [byte] of byte;
      var M,N,i:byte;
          X:Sequence;
          Yes:boolean;
      procedure Next(var X:Sequence;var Yes:boolean);
        var i:byte;
      begin
        i:=N;
        {поиск i}
        while (i&gt;0)and(X[i]=M) do begin X[i]:=1;dec(i) end;
        if i&gt;0 then begin inc(X[i]);Yes:=true end
        else Yes:=false
      end;
    begin
      write('M,N=');readln(M,N);
      for i:=1 to N do X[i]:=1;
      repeat
        for i:=1 to N do write(X[i]);writeln;
        Next(X,Yes)
      until not Yes
    end.
</pre>
<p>&nbsp;<br>
Решение через рекурисю. <img src="/pic/embim1845.gif" width="1" height="1" vspace="1" hspace="1" border="0" alt=""><br>
<img src="/pic/embim1846.png" width="160" height="1" vspace="1" hspace="1" border="0" alt=""><br>
<p>&nbsp;</p>
<p>Опишем рекурсивную процедуру Generate(k), предъявляющую все последовательности длины N из чисел 1,...,M, у которых фиксировано начало X[1],X[2],...,X[k]. Понятно, что при k=N мы имеем тривиальное решение: есть только одна такая последовательность - это она сама.<br>
<p>При k&lt;N будем сводить задачу к k+1:</p>
<pre>
          procedure Generate(k:byte);
            var i,j:byte;
          begin
            if k=N then
              begin for i:=1 to N do write(X[i]);writeln end
            else
              for j:=1 to M do
                begin X[k+1]:=j; Generate(k+1) end
          end;
</pre>
<p>Основная программа теперь выглядит очень просто:</p>
<pre>
        program SequencesRecursion;
          type Sequence=array [byte] of byte;
          var M,N:byte;
              X:Sequence;
          procedure Generate(k:byte);
               ............
        begin
          write('M,N=');readln(M,N);
          Generate(0)        
end.
</pre>
<p><a href="https://algolist.manual.ru" target="_blank">https://algolist.manual.ru</a></p>
