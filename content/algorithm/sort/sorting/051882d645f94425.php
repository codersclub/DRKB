<h1>Алгоритм 1. Сортировка вставками</h1>
<div class="date">01.01.2007</div>

<p>Алгоритм 1. Сортировка вставками. </p>
<p>Это изящный и простой для понимания метод. Вот в чем его суть: создается новый ма ссив, в который мы последовательно вставляем элементы из исходного массива так, чтобы новый массив был упорядоченным. Вставка происходит следующим образом: в конце нового массива выделяется свободная ячейка, далее анализируется элемент, стоящий перед пустой ячейкой (если, конечно, пустая ячейка не стоит на первом месте), и если этот элемент больше вставляемого, то подвигаем элемент в свободную ячейку (при этом на том месте, где он стоял, образуется пустая ячейка) и сравниваем следующий элемент. Так мы прейдем к ситуации, когда элемент перед пустой ячейкой меньше вставляемого, или пустая ячейка стоит в начале массива. Помещаем вставляемый элемент в пустую ячейку . Таким образом, по очереди вставляем все элементы исходного массива. Очевидно, что если до вставки элемента массив был упорядочен, то после вставки перед вставленным элементом расположены все элементы, меньшие его, а после &#8212; большие. Так как порядок элементов в новом массиве не меняется, то сформированный массив будет упорядоченным после каждой вставки. А значит, после последней вставки мы получим упорядоченный исходный массив. Вот как такой алгоритм можно реализовать на языке программирования Pascal:</p>
<pre>
Program InsertionSort;
Var A,B   : array[1..1000] of integer;
    N,i,j  : integer;
Begin
{Определение размера массива A (N) и его заполнение}
 …
{сортировка данных}
 for i:=1 to N do
 begin
  j:=i;
  while (j&gt;1) and (B[j-1]&gt;A[i]) do
   begin
    B[j]:=B[j-1];
    j:=j-1;
   end;
  B[j]:=A[i];
 end;
 {Вывод массива B}
 …
End.
</pre>
<p>В принципе, данную сортировку можно реализовать и без дополнительного массива B, если сортировать массив A сразу при считывании, т. е. осуществлять вставку нового элемента в массив A. </p>
