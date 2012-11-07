<h1>Двоичный (бинарный) поиск элемента в массиве</h1>
<div class="date">01.01.2007</div>

<p>Если у нас есть массив, содержащий упорядоченную последовательность данных, то очень эффективен двоичный поиск.</p>
<p>Переменные Lb и Ub содержат, соответственно, левую и правую границы отрезка массива, где находится нужный нам элемент. Мы начинаем всегда с исследования среднего элемента отрезка. Если искомое значение меньше среднего элемента, мы переходим к поиску в верхней половине отрезка, где все элементы меньше только что проверенного. Другими словами, значением Ub становится (M - 1) и на следующей итерации мы работаем с половиной массива. Таким образом, в результате каждой проверки мы вдвое сужаем область поиска. Так, в нашем примере, после первой итерации область поиска - всего лишь три элемента, после второй остается всего лишь один элемент. Таким образом, если длина массива равна 6, нам достаточно трех итераций, чтобы найти нужное число.</p>
<p>Двоичный поиск - очень мощный метод. Если, например, длина массива равна 1023, после первого сравнения область сужается до 511 элементов, а после второй - до 255. Легко посчитать, что для поиска в массиве из 1023 элементов достаточно 10 сравнений.</p>
<p>Кроме поиска бывает нужно вставлять и удалять элементы. К сожалению, массив плохо приспособлен для выполнения этих операций. О повышении эффективности операций вставки/удаления можно прочитать в разделе про структуры данных.</p>
<pre>
int function BinarySearch (Array A, int Lb, int Ub, int Key);
  begin
  do forever
    M = (Lb + Ub)/2;
    if (Key &lt; A[M]) then
      Ub = M - 1;
    else if (Key &gt; A[M]) then
      Lb = M + 1;
    else
      return M;
    if (Lb &gt; Ub) then
    return -1;
  end;
</pre>
<p><a href="https://algolist.manual.ru" target="_blank">https://algolist.manual.ru</a></p>
