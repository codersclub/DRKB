<h1>Сортировка массива методом прямого выбора</h1>
<div class="date">01.01.2007</div>

Алгоритм сортировки массива по возрастанию методом прямого выбора может быть представлен так: </p>
<p>Просматривая массив от первого элемента, найти минимальный элемент и поместить его на место первого элемента, а первый &#8212; на место минимального. </p>
<p>Просматривая массив от второго элемента, найти минимальный элемент и поместить его на место второго элемента, а второй &#8212; на место минимального. </p>
<p>И так далее до предпоследнего элемента. </p>
<p>Ниже представлена программа сортировки массива целых чисел по возрастанию </p>
<pre>procedure TForm1.ButtonlClick(Sender: TObject);
const
  SIZE = 10;
var
  a: array[1..SIZE] of integer;
  min: integer; { номер минимального элемента в части
                  массива от i до верхней границы массива }
  j: integer; { номер элемента, сравниваемого с минимальным }
  buf: integer; { буфер, используемый при обмене элементов массива }
  i, k: integer;
begin
  // ввод массива
  for i := l to SIZE do
    a[i] := StrToInt(StringGridl.Cells[i - 1, 0]); Iabel2.caption := '';
 
  for i := l to SIZE - 1 do
  begin
    { поиск минимального элемента в части массива от а[1] до a[SIZE]}
    min := i;
    for j := i + l to SIZE do
      if a[j] &lt; a[min] then
        min := j;
 
    { поменяем местами a [min] и a[i] }
    buf := a[i];
    a[i] := a[min];
    a[min] := buf;
 
    { вывод массива }
    for k := l to SIZE do
      Label2.caption := label2.caption + ' ' + IntTostr(a[k]);
    Label2.caption := label2.caption + #13;
  end;
  Label2.caption := label2.caption + #13 + 'MaccMB отсортирован.';
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
