<h1>Поиск минимального (максимального) элемента массива, статистика элементов массива</h1>
<div class="date">01.01.2007</div>

Задачу поиска минимального элемента массива рассмотрим на примере массива целых чисел.</p>
<p>Алгоритм поиска минимального (максимального) элемента массива довольно очевиден: сначала делается предположение, что первый элемент массива является минимальным (максимальным), затем остальные элементы массива последовательно сравниваются с этим элементом. Если во время очередной проверки обнаруживается, что проверяемый элемент меньше (больше) принятого за минимальный (максимальный), то этот элемент становится минимальным (максимальным) и продолжается проверка оставшихся элементов.</p>
<p>Диалоговое окно приложения поиска минимального элемента массива содержит соответствующим образом настроенный компонент stringGridi, который применяется для ввода элементов массива, два поля меток (Label1 и Labeia), использующиеся для вывода информационного сообщения и результата работы программы, и командную кнопку (Buttonl), при щелчке на которой выполняется поиск минимального элемента массива. В табл. 5.4 приведены значения свойств компонента stringGridi.</p>
<p>Свойство                  Значение</p>
<p>ColCount                  005</p>
<p>FixedCols                 000</p>
<p>RowCount                  001</p>
<p>DefaultRowHeight          024</p>
<p>Height                    024</p>
<p>DefaultColWidth           064</p>
<p>Width                     328</p>
<p>Options.goEditing         True</p>
<p>Options.AlwaysShowEditing True</p>
<p>Options.goTabs            True</p>
<p>В листинге 5.6 приведена процедура обработки события Onclick для командной кнопки Button1, которая вводит массив, выполняет поиск мини-мального элемента и выводит результат &#8212; номер и значение минимального элемента массива.</p>
<p>Листинг 5.6. Поиск минимального элемента массива</p>
<pre>
unit lookmin_;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics,
  Controls, Forms, Dialogs, StdCtrls, Grids;
 
type
  TForm1 = class(TForm)
    Label1: TLabel;
    Button1: TButton;
    Label2: TLabel;
    StringGridl: TStringGrid;
    procedure ButtonlClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
{$R *.DFM}
 
 
procedure TForm1.ButtonlClick(Sender: TObject);
const
  SIZE = 5;
var
  a: array[l..SIZE] of integer; // массив целых
  min: integer; // номер минимального элемента массива
  i: integer; // номер элемента, сравниваемого с минимальным
begin
  // ввод массива for i:=1 to SIZE do
  a[i] := StrToInt(StringGridl.Cells[i - 1, 0]);
  // поиск минимального элемента
  min := 1; // пусть первый элемент минимальный
  for i := 2 to SIZE do
    if a[i] &lt; a[min] then
      min := i;
  // вывод результата
  label2.caption := 'Минимальный элемент массива:'
    + IntToStr(a[min] + #13 + 'Номер элемента:' + IntToStr(min);
end;
 
end.
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
</p>
<hr />
<p class="note">Примечание от Vit</p>
<p>боюсь что код приведенный выше представляет интерес для студентов и тех кто изучает алгоритмы програмирования, для тех же кто занимается практической деятельностью изобретать велосипед нет смысла, всё уже сделано до нас, осталосьт заглянуть в модуль Math от Delphi и найти в нём функции нахождения требуемых величин:</p>
<table cellspacing="1" cellpadding="1" border="1" style="border: solid 1px #000000; border-spacing:1px;">
<tr>
<td width="166" bgcolor="#ccffcc" style="width: 166px; background-color: #ccffcc; border: solid 1px #000000;"><p>Функция модуля Math</p>
</td>
<td width="581" bgcolor="#ccffcc" style="width: 581px; background-color: #ccffcc; border: solid 1px #000000;"><p>Описание</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>MaxIntValue</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Returns the largest signed value in an integer array</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>MaxValue</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Returns the largest signed value in an array</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>Mean</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Returns the average of all values in an array</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>MeanAndStdDev</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Calculates the mean and standard deviation of array elements</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>MinIntValue</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Returns the smallest signed value in an integer array</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>MinValue</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Returns smallest signed value in an array</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>MomentSkewKurtosis</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Calculates the mean, variance, skew, and kurtosis</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>Norm</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Returns the Euclidean 'L-2' norm.</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>PopnStdDev</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Calculates the population standard deviation</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>PopnVariance</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Calculates the population variance</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>StdDev</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Returns the sample standard deviation for elements in an array.</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>Sum</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Returns the sum of the elements in an array.</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>SumInt</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Returns the sum of the elements in an integer array.</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>SumOfSquares</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Returns the sum of the squared values from a data array.</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>SumsAndSquares</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Returns the sum of the values and the sum of the squared values in an array.</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>TotalVariance</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Returns the statistical variance from an array of values.</p>
</td>
</tr>
<tr>
<td width="166" style="width: 166px; border: solid 1px #000000;"><p>Variance</p>
</td>
<td width="581" style="width: 581px; border: solid 1px #000000;"><p>Calculates statistical sample variance from an array of data.
</td>
</tr>
</table>
<p>Впрочем тем кто изучает алгоритмику неплохо было бы взглянуть на исходники этого модуля Math, где и найти реализацию приведенных функций.</p>
<div class="author">Автор: Vit</div>
