<h1>Запуск и закрытие Excel, добавление и удаление книг и листов</h1>
<div class="date">01.01.2007</div>


<pre class="delphi">
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Запуск и закрытие Excel, добавление и удаление книг и листов
 
На данный момент работает:
- вызов и закрытие Excel
- добавление новых, открытие ранее созданных и удаление рабочих книг
- добавление и удаление листов в рабочие книги
 
Зависимости: ComObj, SysUtils,Dialogs,Controls;
Автор:       lookin, lookin@mail.ru, Екатеринбург
Copyright:   lookin
Дата:        04 мая 2002 г.
********************************************** }
 
unit MSExcel;
 
interface
 
uses ComObj, SysUtils,Dialogs,Controls;
 
  procedure CallExcel(Show: boolean);
  procedure CloseExcel;
  procedure AddWorkBook(WorkBookName: Ansistring);
  procedure OpenWorkBook(WorkBookName: Ansistring);
  procedure CloseWorkBook(WorkBookName: Ansistring);
  procedure ActivateWorkBook(WorkBookName: Ansistring);
  procedure ActivateWorkSheet(WorkBookName,WorkSheetName: Ansistring);
  function WorkBookIndex(WorkBookName: Ansistring): integer;
  function WorkSheetIndex(WorkBookName,WorkSheetName: Ansistring): integer;
  procedure CheckExtension(Name: Ansistring);
  procedure AddWorkSheet(WorkBookName,WorkSheetName: Ansistring);
  procedure DeleteWorkSheet(WorkBookName,WorkSheetName: Ansistring);
 
var Excel: Variant;
 
implementation
 
 
procedure CallExcel(Show: boolean);
begin
  if VarIsEmpty(Excel)=true then begin
  Excel:=CreateOleObject('Excel.Application');
  if Show then Excel.Visible:=true; end;
end;
 
procedure CloseExcel;
begin
  if VarIsEmpty(Excel)=false then begin
  Excel.Quit; Excel:=0; end;
end;
 
procedure AddWorkBook(WorkBookName: Ansistring);
var k: integer;
begin
  CheckExtension(WorkBookName);
  if VarIsEmpty(Excel)=true then begin
  Excel:=CreateOleObject('Excel.Application'); Excel.Visible:=true; end;
  k:=WorkBookIndex(WorkBookName);
  if k=0 then begin Excel.Workbooks.Add;
  Excel.ActiveWorkbook.SaveCopyAs(FileName:=WorkBookName);
  Excel.ActiveWorkbook.Close;
  Excel.Workbooks.Open(WorkBookName); end else
  MessageDlg('Книга с таким именем уже существует.',mtWarning,[mbOk],0);
end;
 
procedure OpenWorkBook(WorkBookName: Ansistring);
var k: integer;
begin
  CheckExtension(WorkBookName);
  if VarIsEmpty(Excel)=true then begin
  Excel:=CreateOleObject('Excel.Application'); Excel.Visible:=true; end;
  k:=WorkBookIndex(WorkBookName);
  if k=0 then Excel.Workbooks.Open(WorkBookName) else
  MessageDlg('Книга с таким именем уже открыта.',mtWarning,[mbOk],0);
end;
 
procedure CloseWorkBook(WorkBookName: Ansistring);
var k: integer;
begin
  if VarIsEmpty(Excel)=false then begin
  k:=WorkBookIndex(WorkBookName);
  if k&lt;&gt;0 then Excel.ActiveWorkbook.Close(WorkBookName) else
  MessageDlg('Книга с таким именем отсутствует.',mtWarning,[mbOk],0); end;
end;
 
procedure ActivateWorkBook(WorkBookName: Ansistring);
var k: integer;
begin
  if VarIsEmpty(Excel)=false then begin
  k:=WorkBookIndex(WorkBookName);
  if k&lt;&gt;0 then Excel.WorkBooks[k].Activate; end;
end;
 
procedure ActivateWorkSheet(WorkBookName,WorkSheetName: Ansistring);
var k,j: integer;
begin
  if VarIsEmpty(Excel)=false then begin
  k:=WorkBookIndex(WorkBookName);
  j:=WorkSheetIndex(WorkBookName,WorkSheetName);
  if j&lt;&gt;0 then Excel.WorkBooks[k].Sheets[j].Activate; end;
end;
 
procedure AddWorkSheet(WorkBookName,WorkSheetName: Ansistring);
var k,j: integer;
begin
  if VarIsEmpty(Excel)=false then begin
  k:=WorkBookIndex(WorkBookName);
  if k&lt;&gt;0 then begin Excel.DisplayAlerts:=False;
  Excel.Workbooks[k].Sheets.Add;
  j:=WorkSheetIndex(WorkBookName,WorkSheetName);
  if j=0 then Excel.Workbooks[k].ActiveSheet.Name:=WorkSheetName;
  end; end;
end;
 
procedure DeleteWorkSheet(WorkBookName,WorkSheetName: Ansistring);
var k,j: integer;
begin
  if VarIsEmpty(Excel)=false then begin k:=WorkBookIndex(WorkBookName);
  Excel.DisplayAlerts:=false;
  j:=WorkSheetIndex(WorkBookName,WorkSheetName);
  if j&lt;&gt;0 then Excel.Workbooks[k].Sheets[j].Delete else
  MessageDlg('Листа с таким именем в этой книге нет.',mtWarning,[mbOk],0); end;
end;
 
procedure CheckExtension(Name: Ansistring);
var s: string;
begin
//проверка расширения
  s:=ExtractFileExt(Name);
  if LowerCase(s)&lt;&gt;'.xls' then
  if MessageDlg('Вы задали имя книги с нестандартным расширением. Продолжить?',
  mtWarning,[mbYes,mbCancel],0)=mrCancel then Abort;
end;
 
function WorkBookIndex(WorkBookName: Ansistring): integer;
var i,n: integer;
begin
//проверка на наличие книги с этим именем
  n:=0;
  if VarIsEmpty(Excel)=false then for i:=1 to Excel.WorkBooks.Count do
  if Excel.WorkBooks[i].FullName=WorkBookName then begin n:=i; break; end;
  WorkBookIndex:=n;
end;
 
function WorkSheetIndex(WorkBookName,WorkSheetName: Ansistring): integer;
var i,k,n: integer;
begin
//проверка на наличие листа с этим именем в книге с этим именем
  n:=0;
  if VarIsEmpty(Excel)=false then begin k:=WorkBookIndex(WorkBookName);
  for i:=1 to Excel.WorkBooks[k].Sheets.Count do
  if Excel.WorkBooks[k].Sheets[i].Name=WorkSheetName then begin
  n:=i; break; end; end; WorkSheetIndex:=n;
end;
 
end. 
</pre>

<p> Пример использования:</p>

<pre class="delphi">
procedure TForm1.Button1Click(Sender: TObject);
begin
//вызов Excel, true - если хотите при вызове Excel отобразить окно Excel
  CallExcel(true);
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
//добавление новой рабочей книги с заданным именем
//ВАЖНО: используйте полное имя рабочей книги, т.е. включая путь
  AddWorkBook('D:\qwerty.xls');
end;
 
procedure TForm1.Button3Click(Sender: TObject);
begin
//добавление листа с именем ff в рабочую книгу D:\qwerty.xls
  AddWorksheet('D:\qwerty.xls','ff');
end;
 
procedure TForm1.Button4Click(Sender: TObject);
begin
//активация рабочей книги
  ActivateWorkBook('D:\1234.xls');
end;
 
procedure TForm1.Button5Click(Sender: TObject);
begin
//активация листа в рабочей книге
  ActivateWorkSheet('D:\qwerty.xls','ff');
end;
 
procedure TForm1.Button6Click(Sender: TObject);
begin
//открытие рабочей книги
  OpenWorkBook('D:\qwerty.xls');
end;
 
procedure TForm1.Button7Click(Sender: TObject);
begin
//закрытие рабочей книги
  CloseWorkBook('D:\qwerty.xls');
end;
 
procedure TForm1.Button8Click(Sender: TObject);
begin
//удаление листа из рабочей книги
  DeleteWorkSheet('D:\qwerty.xls','ff');
end;
 
procedure TForm1.Button9Click(Sender: TObject);
begin
//закрытие Excel
  CloseExcel;
end;
 
end. 
</pre>

