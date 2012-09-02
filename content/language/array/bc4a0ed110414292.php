<h1>Использование многомерного массива</h1>
<div class="date">01.01.2007</div>



<pre>
type RecType = integer; {&lt;-- здесь задается тип элементов массива}
 
const MaxRecItem = 65520 div sizeof(RecType);
 
type = MyArrayType = array[0..MaxRecItem] of RecType;
type = MyArrayTypePtr = ^MyArrayType;
 
var MyArray: MyArrayTypePtr;
begin
  ItemCnt := 10; {количество элементов массива, которые необходимо распределить}
  GetMem(MyArray, ItemCnt * sizeof(MyArray[1])); {распределение массива}
  MyArray^[3] := 10; {доступ к массиву}
  FreeMem(MyArray, ItemCnt * sizeof(MyArray[1])); {освобождаем массив после работы с ним}
end;
</pre>

<p>Michael Day</p>
<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>


<hr />
<p class="p_Heading1">Автор: Steve Schafer </p>

<pre>
type
  PRow = ^TRow;
  TRow = array[0..16379] of Single;
 
  PMat = ^TMat;
  TMat = array[0..16379] of PRow;
 
var
  Mat: PMat;
  X, Y, Xmax, Ymax: Integer;
 
begin
  Write('Задайте размер массива: ');
  ReadLn(Xmax, Ymax);
  if (Xmax &lt;= 0) or (Xmax &gt; 16380) or (Ymax &lt;= 0) or (Ymax &gt; 16380) then
  begin
    WriteLn('Неверный диапазон. Не могу продолжить.');
    Exit;
  end;
  GetMem(Mat, Xmax * SizeOf(PRow));
  for X := 0 to Xmax - 1 do
  begin
    GetMem(Mat[X], Ymax * SizeOf(Single));
    for Y := 0 to Ymax - 1 do
      Mat^[X]^[Y] := 0.0;
  end;
  WriteLn('Массив инициализирован и готов к работе.');
  WriteLn('Но эта программа закончила свою работу.');
end.
 
 
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

