<h1>Доступ к ячейкам Excel</h1>
<div class="date">01.01.2007</div>

<p>Когда мы уже умеем открывать книгу, выбирать рабочий лист и сохранять книгу, то чтобы создать простой документ в Excel, необходимо и достаточно научиться записывать информацию в ячейки таблицы. Шаблоны многих документов уже разработаны и представлены в разнообразных справочных системах, и целесообразно научиться использовать их в своих приложениях.</p>
Лист книги Excel состоит из множества строк и столбцов, пересечения которых представляют собой отдельные ячейки или множество ячеек, если пересекается множество строк и столбцов. Каждая ячейка может содержать информацию в виде данных различного типа или формул. Кроме данных, ячейка имеет другие свойства, которые определяют ее размер, цвет, стиль, формат данных и другие параметры.</p>
Доступ к ячейке или ячейкам в Excel предоставляет объект Range. Этот объект обладает всеми необходимыми свойствами и методами, чтобы писать, читать из ячейки и изменять все ее свойства. Для того, чтобы просто записать информацию в ячейку, необходимо присвоить объекту Range значение, записанное в переменной типа variant. Например: Range['A1']:=123.25; или Range['A1']:='ячейка';. Для записи (чтения) в ячейку из приложений на Delphi разработаем несколько функций. Аргумент (range:string) этих функций может принимать значения, которые соответствуют одной ячейке (например 'A1') или группе ячеек (например 'A1:D5').</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;"><pre>
Function SetRange (sheet:variant;range:string;
  value_:variant):boolean;
begin
 SetRange:=true;
 try
  E.ActiveWorkbook.Sheets.Item[sheet].Range[range]:=value_;
 except
  SetRange:=false;
 end;
End;
</pre>
Читать информацию одновременно можно только из одной ячейки. Если попытаться читать из группы ячеек, то можно получить ошибку. Поэтому аргумент range:string в функции GetRange принимает только такие значения, как, например 'A1'. В этих функциях чтения и записи, а также и во всех последующих аргумент sheet может принимать как числовые значения (номер листа), так и строковые (имя листа).</p>
<pre>
Function GetRange (sheet:variant;range:string):variant;
begin
 try
  GetRange:=E.ActiveWorkbook.Sheets.Item[sheet].Range[range];
 except
  GetRange:=null;
 end;
End;
</pre>
&nbsp;</p>
<h1>Доступ к ячейкам Excel</h1>

