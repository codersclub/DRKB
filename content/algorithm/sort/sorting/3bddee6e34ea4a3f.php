<h1>Алгоритм 8. Цифровая сортировка</h1>
<div class="date">01.01.2007</div>

<p>Алгоритм 8. Цифровая сортировка. </p>
<p>Этой сортировкой можно сортировать целые неотрицательные числа большого диапазона. Идея состоит в следующем: отсортировать числа по младшему разряду, потом устойчивой сортировкой сортируем по второму, третьему, и так до старшего разряда. В качестве устойчивой сортировки можно выбрать сортировку подсчетом, в виду малого времени работы. Реализация такова: </p>
<pre>
Program RadixSort;
Var A,B   : array[1..1000] of word;
   N,i    : integer;
   t      : longint;
Procedure Sort; {сортировка подсчетом}
Var C    : array[0..9] of integer;
    j     : integer;
Begin
 For j:=0 to 9 do
 C[j]:=0;
 For j:=1 to N do
 C[(A[j] mod (t*10)) div t]:= C[(A[j] mod (t*10)) div t]+1;
 For j:=1 to 9 do
 C[j]:=C[j-1]+C[j];
 For j:=N downto 1 do
 begin
  B[C[(A[j] mod (t*10)) div t]]:=A[j];
  C[(A[j] mod (t*10)) div t] := C[(A[j] mod (t*10)) div t]-1;
 end;
End;
Begin
{Определение размера массива A (N) и его заполнение}
 …
{сортировка данных}
 t:=1;
 for i:=1 to 5 do
 begin
  Sort;
  A:=B;
  t:= t*10;
 end;
{Вывод массива A}
 …
End.
</pre>
<p>Так как сортировка подсчетом вызывается константное число раз, то время работы всей сортировки есть O(n). Заметим, что таким способом можно сортировать не только числа, но и строки, если же использовать сортировку слиянием в качестве устойчивой, то можно сортировать объекты по нескольким полям. </p>
<p>Теперь вы владеете достаточным арсеналом, чтобы сортировать все что угодно и как угодно. Помните, что выбор нужной вам сортировки зависит от того, какие данные вы будете сортировать и где вы их будете сортировать. </p>
<p>P.S. Все программы рабочие &#8212; если, конечно, вам не лень будет заменить три точки на код ввода и вывода массивов :-). </p>
