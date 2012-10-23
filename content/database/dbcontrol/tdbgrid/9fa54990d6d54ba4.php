<h1>Как определить изменение фокуса строки в TDBGrid?</h1>
<div class="date">01.01.2007</div>


<p>Используйте событие OnDataChange объекта Datasource, соединенного с DBGrid. Если параметр State в обработчике событие равен dsBrowse, значит вы перешли в новую строку (или только что открыли таблицу).</p>

<p>Почему сетка не поддерживает такое событие? Поскольку сетка может быть не единственным элементом управления, оторбажающим данные из текущей строки и может быть не единственным элементом, позволяющим осуществлять перемещение от строки к строке. С помощью Datasource обработка события осуществляется централизованно.</p>

<p>Я не уверен в том, что проблему можно решить, обрабатывая событие одинарного щелчка, для отслеживания события изменения строк я рекомендую использовать событие TDatasource.OnDataChange, а для колонок - TDBGrid.OnColEnter/Exit.</p>

<p>Лично я пользуюсь следующей рабочей технологией:</p>

<p>Для того, чтобы обнаружить изменения текущей строки, воспользуйтесь событием TDataSource OnDataChange. OnDataChange возникает при прокрутке или щелчке на другой строке. Обработчик события может выглядеть приблизительно так:</p>

<p>procedure Form1.DSrc1DataChange(Sender: TObject; Field: TField);</p>

<p>где Field является колонкой, где произошло изменение.</p>

<p>Поля TTable могут использоваться для сравнения текущих выбранных строк полей (ключ) с вашими требованиями. С той же целью может быть использовано и свойство TDBGrid Fields. Для примера:</p>

<p>if tbl1.Fields[0].AsString = 'BlaBlaBla' then ...</p>

<p>или</p>

<p>if dbGrid1.Fields[I].IsNull then ...</p>

<p>Для отслеживания изменения колонки, используйте события TDBGrid OnColExit &amp; OnColEnter. Для определения выбранной к настоящему времени колонки воспользуйтесь свойствами TDBGrid SelectedField и SelectedIndex.</p>
<p>Когда выбирается другая колонка другой строки, вы получаете события OnColExit, OnColEnter и OnDataChange.</p>

<p>Можно пойти и "кривым" путем, взявшись за обработку события TDBGrid OnDrawDataCell, которое возникает когда ячейка выбирается, или когда сетка скроллируется. Обработчик события может выглядеть примерно так:</p>

<p>procedure Form1.dbGrid1DrawDataCell(Sender: TObject; Rect: TRect;</p>
<p>Field: TField; State: TGridDrawState);</p>

<p>При изменении ячейки вы получаете поток событий, поэтому вам нужно каким-то образом их фильтровать.</p>

<p>Если у вас нет проблем в создании "101 изменения" стандартных компонентов - что является проблемой для меня 8-), то попробуйте это. Это легко.</p>
<p>Чтобы иметь доступ к индексу строки или колонки выбранной ячейки, вы должны унаследовать ваш класс от TCustomGrid и опубликать свойства времени выполнения Row и Col (текущие строка и колонка сетки, не таблицы!!):</p>

<pre>
type
TSampleDBGrid = class(TCustomGrid)
public
property Col;
property Row;
end;
</pre>


<p>в соответствующей процедуре или обработчике события осуществите приведение типа:</p>
<pre>
var
G: TSampleDBGrid;
begin
G := TSampleDBGrid(myDBGrid1);
if G.Row = I then ...
if G.Col = J then ...
</pre>


<p>Дело в том, что TDBGrid является потомком TCustomGrid, который имеет несколько свойств, содержащих координаты сетки, но это не опубликовано в TDBGrid.</p>

<p>...из чего я могу заключить, что вы должны это сделать программным путем. Подразумеваем, что сетка уже существует, и у вас есть доступ к основной таблице TTable:</p>
<pre>
grid.colcount := dbGrid.fieldcount;
table.first;
row := 0;
while not table.eof do 
  begin
    grid.rowcount := row + 1;
    for i := 0 to grid.colcount-1 do
      grid.cells[i,row] := dbGrid.fields[i].asString;
    table.next;
    inc (row);
  end;
</pre>


<p>Могут быть ошибки, но это должно помочь.</p>

<p>Посмотрите на следующий код, он может вам помочь. Он берет у элемента управления свойсто 'Name' и помещает его в свойство 'Caption' метки.</p>
<pre>
unit Unit1;
 
interface
 
uses
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  Forms, Dialogs, StdCtrls;
 
type
  TForm1 = class(TForm)
    Label1: TLabel;
    Edit1: TEdit;
    Edit2: TEdit;
    Button1: TButton;
    procedure Button1Click(Sender: TObject);
    procedure Edit1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure Edit2MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  close;
end;
 
procedure TForm1.Edit1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
  Label1.Caption := TEdit(Sender).Name;
end;
 
procedure TForm1.Edit2MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
  Label1.Caption := TEdit(Sender).Name;
end;
 
end.
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

