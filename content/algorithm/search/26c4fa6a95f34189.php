<h1>Алгоритм простого перебора</h1>
<div class="date">01.01.2007</div>

Ниже приведен текст программы поиска в массиве целых чисел. Перебор элементов массива осуществляется инструкцией repeat, в теле которой инструкция if сравнивает текущий элемент массива с образцом и присваивает переменной found значение true, если текущий элемент и образец равны. </p>
<p>Цикл завершается, если в массиве обнаружен элемент, равный образцу (в этом случае значение переменной found равно true), или если проверены все элементы массива. По завершении цикла по значению переменной found можно определить, успешен поиск или нет. </p>
<pre>
unit s_found_;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes,
  Graphics, Controls, Forms, Dialogs,
  StdCtrls, Grids;
 
type
  TForm1 = class(TForm)
    Label1: TLabel;
    Label2: TLabel;
    Button1: TButton;
    Edit2: TEdit;
    StringGridi: TStringGrid;
    procedure ButtonlClick(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
end;
 
var
Form1: TForm1 ;
 
implementation
{$R *.DFM}
 
{ поиск в массиве перебором }
procedure TForml.ButtonlClick(Sender: TObject);
const
  SIZE = 5;
var
  a: array[1..SIZE] of integer; //массив
  obr: integer; // образец для поиска
  found: boolean; // TRUE — совпадение образца с элементом массива
  i: integer; // индекс элемента массива
begin
  // ввод массива for i:=l to SIZE do
  a[i] := StrToInt(StringGridl.Cells[i - 1, 0]);
  // ввод образца для поиска
  obr := StrToInt(edit2.text);
  // поиск
  found := FALSE; // пусть нужного элемента в массиве нет
  i := 1;
  repeat
    if a[i] = obr then
      found := TRUE
    else
      i := i + 1;
  until (i &gt; SIZE) or (found = TRUE);
 
  if found then
    ShowMessage('Совпадение с элементом номер '
      + IntToStr(i) + #13 + 'Поиск успешен.')
  else
    ShowMessage('Совпадений с образцом нет.');
end;
 
end.
</pre>
<p>Очевидно, что чем больше элементов в массиве и чем дальше расположен нужный элемент от начала массива, тем дольше программа будет искать необходимый элемент. </p>
<p>Поскольку операции сравнения применимы как к числам, так и к строкам, данный алгоритм может использоваться для поиска как в числовых, так и в строковых массивах. </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
