<h1>Запись и чтение чисел в BLOB-поле</h1>
<div class="date">01.01.2007</div>



<p>Мне нужно записать серию чисел в файл Paradox в blob-поле. Числа получаются из значений компонент, размещенных на форме. Затем мне нужно будет считывать числа из blob-поля и устанавливать согласно им значения компонент. Как мне сделать это?</p>

<p>Вы можете начать свое исследование со следующего модуля:</p>
<pre>
unit BlobFld;
 
interface
 
uses
  SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
  Forms, Dialogs, StdCtrls, Buttons, DBTables, DB, ExtCtrls, DBCtrls,
  Grids, DBGrids;
 
type
  TFrmBlobFld = class(TForm)
    BtnWrite: TBitBtn;
    Table1: TTable;
    DataSource1: TDataSource;
    DBNavigator1: TDBNavigator;
    LbxDisplayBlob: TListBox;
    Table1pubid: TIntegerField;
    Table1comments: TMemoField;
    Table1UpdateTime: TTimeField;
    Table1Real1: TFloatField;
    Table1Real2: TFloatField;
    Table1Real3: TFloatField;
    Table1Curr1: TCurrencyField;
    Table1Blobs: TBlobField;
    Table1Bytes: TBytesField;
    CbxRead: TCheckBox;
    procedure BtnWriteClick(Sender: TObject);
    procedure DataSource1DataChange(Sender: TObject; Field: TField);
    procedure FormShow(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
  private
    { Private-Deklarationen }
  public
    { Public-Deklarationen }
  end;
 
var
  FrmBlobFld: TFrmBlobFld;
 
implementation
 
{$R *.DFM}
 
type
  ADouble = array[1..12] of double;
  PADouble = ^ADouble;
 
procedure TFrmBlobFld.BtnWriteClick(Sender: TObject);
var
  i: integer;
  myBlob: TBlobStream;
  v: longint;
begin
  Table1.Edit;
 
  myBlob := TBlobStream.Create(Table1Blobs, bmReadWrite);
  try
    v := ComponentCount;
    myBlob.Write(v, sizeof(longint));
 
    for i := 0 to ComponentCount - 1 do
    begin
      v := Components[i].ComponentIndex;
      myBlob.Write(v, sizeof(longint));
    end;
  finally
    Table1.Post;
    myBlob.Free;
  end;
end;
 
procedure TFrmBlobFld.DataSource1DataChange(Sender: TObject; Field: TField);
var
  i: integer;
  myBlob: TBlobStream;
  t: longint;
  v: longint;
begin
  if CbxRead.Checked then
  begin
    LbxDisplayBlob.Clear;
 
    myBlob := TBlobStream.Create(Table1Blobs, bmRead);
    try
      myBlob.Read(t, sizeof(longint));
      LbxDisplayBlob.Items.Add(IntToStr(t));
 
      for i := 0 to t - 1 do
      begin
        myBlob.Read(v, sizeof(longint));
        LbxDisplayBlob.Items.Add(IntToStr(v));
      end;
    finally
      myBlob.Free;
    end;
  end;
end;
 
procedure TFrmBlobFld.FormShow(Sender: TObject);
begin
  Table1.Open;
end;
 
procedure TFrmBlobFld.FormClose(Sender: TObject;
  var Action: TCloseAction);
begin
  Table1.Close;
end;
 
end.
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>


<hr />
Как мне в таблице Paradox скопировать массив целочисленных чисел в TBlobField и наоборот? Элементы массива являются точками графика данных, который я хочу выводить, если запись доступна.</p>

<p>Запишите массив в поток памяти и затем используйте метод TBlob LoadFromStream. Для извлечения данных используйте метод TBlob SaveToStream (сохранение и извлечение массива из потока памяти).</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

