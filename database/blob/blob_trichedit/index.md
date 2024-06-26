---
Title: Связать поле BLOB-таблицы Paradox с компонентом TRichEdit через потоки
Author: Сергей Лагонский
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Связать поле BLOB-таблицы Paradox с компонентом TRichEdit через потоки
======================================================================

Я сам занимался этой задачей и мое предыдущее письмо к Вам явилось
результатом экспериментов над TRichEdit. Поэтому я хочу предложить Вам
пример проэкта, в котором я связываю поле BLOB таблицы Paradox с
компонентом TRichEdit через потоки. Кроме того я использую библиотеку
ZLib из стандартного приложения к Delphi 3 CSS. Это позволяет по ходу
перекачивания данных в таблицу сжимать текст, а при чтении -
распаковывать его чем достигается уменьшение размера .MB-файла, что
полезно при большом количестве записей с BLOB-полем.

В заключение хочу сказать несколько слов о библиотеке ZLib.dcu (размер
48496 байт, дата создания 24.03.97г.) которая включена в поставку Delphi
3. При использовании конструктора TDecompressStream почему-то
генерировался Default Beep и это очень задерживало выполнение
декомпрессии. По счастью в поставку входит и исходный текст ZLib.pas. Я
перекомпилировал модуль с помощью тестового примера, также входящего в
поставку, при этом указав в настройках проэкта не включать отладочную
информацию. В результате размер ZLib.dcu стал равным 45681 байт, а
сигнал генерироваться перестал.

Теперь о проэкте. Он имеет одну форму frmMain. Содержимое файлов проэкта
привожу ниже. Для работы также необходима таблица Table.db, имеющая
структуру:

       Имя поля        Тип        Размер
       ID              +
       BLOBData        B        64

и Alias с именем CBDB указывающий на каталог с этой таблицей.

Для упрощения размещения компонентов в форме проделайте следующее:

- Создайте новый проект;
- Скопируйте выделенную красным цветом часть файла Main.dfm в буфер обмена;
- Сделайте активной вновь созданную форму и вставте в нее содержимое буфера;
- Измените свойства самой формы в соответствии с нижеприведенным описанием.

```
// Файл Main.dfm:
 
object frmMain: TfrmMain
 
  Left = 476
    Top = 347
    BorderStyle = bsSingle
    Caption = 'Compressed BLOB'
    ClientHeight = 235
    ClientWidth = 246
    Font.Charset = DEFAULT_CHARSET
    Font.Color = clWindowText
    Font.Height = -11
    Font.Name = 'MS Sans Serif'
    Font.Style = []
    Position = poScreenCenter
    OnShow = FormShow
    PixelsPerInch = 96
    TextHeight = 13
    object SB1: TSpeedButton
    Left = 1
      Top = 209
      Width = 25
      Height = 25
      Hint = 'Добавить'
      Glyph.Data = {
    76010000424D7601000000000000760000002800000020000000100000000100
    04000000000000010000130B0000130B00001000000000000000000000000000
    800000800000008080008000000080008000808000007F7F7F00BFBFBF000000
    FF0000FF000000FFFF00FF000000FF00FF00FFFF0000FFFFFF00333333333333
    33333333333FFFFFFFFF333333000000000033333377777777773333330FFFFF
    FFF03333337F333333373333330FFFFFFFF03333337F3FF3FFF73333330F00F0
    00F03333F37F773777373330330FFFFFFFF03337FF7F3F3FF3F73339030F0800
    F0F033377F7F737737373339900FFFFFFFF03FF7777F3FF3FFF70999990F00F0
    00007777777F7737777709999990FFF0FF0377777777FF37F3730999999908F0
    F033777777777337F73309999990FFF0033377777777FFF77333099999000000
    3333777777777777333333399033333333333337773333333333333903333333
    3333333773333333333333303333333333333337333333333333}
    NumGlyphs = 2
      ParentShowHint = False
      ShowHint = True
      OnClick = SB1Click
  end
  object SB2: TSpeedButton
    Left = 25
      Top = 209
      Width = 25
      Height = 25
      Hint = 'Удалить'
      Glyph.Data = {
    76010000424D7601000000000000760000002800000020000000100000000100
    0400000000000001000000000000000000001000000000000000000000000000
    8000008000000080800080000000800080008080000080808000C0C0C0000000
    FF0000FF000000FFFF00FF000000FF00FF00FFFF0000FFFFFF00333333333333
    33333333333FFFFFFFFF333333000000000033333377777777773333330FFFFF
    FFF03333337F333333373333330FFFFFFFF03333337F3FF3FFF73333330F00F0
    00F033333F7F773777373333300FFFFFFFF03333F73FFF3FF3F733330C0F0800
    F0F0333F773F337737373330CC0FFFFFFFF033F777FFFFF3FFF7330CCCCC00F0
    00003F777777F737777730CCCCCC0FF0FF03F7777777FF37F3730CCCCCCC08F0
    F03377777777F337F73330CCCCCC0FF0033337777777FFF77333330CCCCC0000
    333333777777777733333330CC3333333333333777333333333333330C333333
    3333333377333333333333333033333333333333373333333333}
    NumGlyphs = 2
      ParentShowHint = False
      ShowHint = True
      OnClick = SB2Click
  end
  object SB3: TSpeedButton
    Left = 49
      Top = 209
      Width = 25
      Height = 25
      Hint = 'Редактировать'
      Glyph.Data = {
    76010000424D7601000000000000760000002800000020000000100000000100
    04000000000000010000120B0000120B00001000000000000000000000000000
    800000800000008080008000000080008000808000007F7F7F00BFBFBF000000
    FF0000FF000000FFFF00FF000000FF00FF00FFFF0000FFFFFF00333333000000
    000033333377777777773333330FFFFFFFF03FF3FF7FF33F3FF700300000FF0F
    00F077F777773F737737E00BFBFB0FFFFFF07773333F7F3333F7E0BFBF000FFF
    F0F077F3337773F3F737E0FBFBFBF0F00FF077F3333FF7F77F37E0BFBF00000B
    0FF077F3337777737337E0FBFBFBFBF0FFF077F33FFFFFF73337E0BF0000000F
    FFF077FF777777733FF7000BFB00B0FF00F07773FF77373377373330000B0FFF
    FFF03337777373333FF7333330B0FFFF00003333373733FF777733330B0FF00F
    0FF03333737F37737F373330B00FFFFF0F033337F77F33337F733309030FFFFF
    00333377737FFFFF773333303300000003333337337777777333}
    NumGlyphs = 2
      ParentShowHint = False
      ShowHint = True
      OnClick = SB3Click
  end
  object SB4: TSpeedButton
    Left = 73
      Top = 209
      Width = 25
      Height = 25
      Hint = 'Отменить редактирование'
      Glyph.Data = {
    DE010000424DDE01000000000000760000002800000024000000120000000100
    0400000000006801000000000000000000001000000000000000000000000000
    80000080000000808000800000008000800080800000C0C0C000808080000000
    FF0000FF000000FFFF00FF000000FF00FF00FFFF0000FFFFFF00333333333333
    333333333333333333333333000033338833333333333333333F333333333333
    0000333911833333983333333388F333333F3333000033391118333911833333
    38F38F333F88F33300003339111183911118333338F338F3F8338F3300003333
    911118111118333338F3338F833338F3000033333911111111833333338F3338
    3333F8330000333333911111183333333338F333333F83330000333333311111
    8333333333338F3333383333000033333339111183333333333338F333833333
    00003333339111118333333333333833338F3333000033333911181118333333
    33338333338F333300003333911183911183333333383338F338F33300003333
    9118333911183333338F33838F338F33000033333913333391113333338FF833
    38F338F300003333333333333919333333388333338FFF830000333333333333
    3333333333333333333888330000333333333333333333333333333333333333
    0000}
    NumGlyphs = 2
      ParentShowHint = False
      ShowHint = True
      OnClick = SB4Click
  end
  object P1: TPanel
    Left = 0
      Top = 0
      Width = 246
      Height = 206
      BevelInner = bvRaised
      BevelOuter = bvLowered
      BevelWidth = 2
      TabOrder = 0
      object RE: TRichEdit
      Left = 5
        Top = 5
        Width = 236
        Height = 196
        ScrollBars = ssVertical
        TabOrder = 0
    end
  end
  object DBN: TDBNavigator
    Left = 149
      Top = 209
      Width = 96
      Height = 25
      DataSource = DS
      VisibleButtons = [nbFirst, nbPrior, nbNext, nbLast]
      TabOrder = 1
  end
  object T1: TTable
    Active = True
      DatabaseName = 'CBDB'
      TableName = 'table.db'
      Left = 5
      Top = 5
      object T1ID: TAutoIncField
      FieldName = 'ID'
        Visible = False
    end
    object T1BLOBData: TBlobField
      FieldName = 'BLOBData'
        Visible = False
        BlobType = ftBlob
        Size = 64
    end
  end
  object OD: TOpenDialog
    DefaultExt = 'rtf'
      Filter = 'RTF-файлы|*.rtf|Все файлы|*.*'
      Title = 'Выберите файл'
      Left = 5
      Top = 35
  end
  object DS: TDataSource
    DataSet = T1
      OnDataChange = DSDataChange
      Left = 35
      Top = 5
  end
end
```

```
// Файл Main.pas:
unit Main;
 
interface
 
uses
 
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  Db, DBTables, StdCtrls, ComCtrls, ExtCtrls, DBCtrls, Buttons, swDBPanl,
  swRecPos;
type
 
  TfrmMain = class(TForm)
    T1: TTable;
    T1ID: TAutoIncField;
    T1BLOBData: TBlobField;
    OD: TOpenDialog;
    P1: TPanel;
    SB1: TSpeedButton;
    SB2: TSpeedButton;
    SB3: TSpeedButton;
    SB4: TSpeedButton;
    DS: TDataSource;
    DBN: TDBNavigator;
    procedure SB1Click(Sender: TObject);
    procedure SB2Click(Sender: TObject);
    procedure SB3Click(Sender: TObject);
    procedure SB4Click(Sender: TObject);
    procedure DSDataChange(Sender: TObject; Field: TField);
    procedure FormShow(Sender: TObject);
  private
    EF: boolean;
    procedure SetButtons;
    procedure UpdateEditor;
    procedure StoreFromFile;
    procedure StoreFromEditor;
  public
    { Public declarations }
  end;
 
var
  frmMain: TfrmMain;
 
implementation
uses ZLib;
 
{$R *.DFM}
 
const
  LID: longint = 0;
 
procedure TfrmMain.SetButtons;
var
  c1: boolean;
begin
  c1 := T1.RecordCount > 0;
 
  SB2.Enabled := not EF and c1;
  SB3.Enabled := not EF and c1;
  SB4.Enabled := EF;
end;
 
procedure TfrmMain.UpdateEditor;
var
  Buf: TStream;
 
  ZStream: TCustomZLibStream;
  id: longint;
begin
 
  id := T1ID.AsInteger;
  if (id = LID) and not EF then
    exit
  else
    LID := id;
  Buf := TMemoryStream.Create;
  T1BLOBData.SaveToStream(Buf);
  if Buf.Size > 0 then
  begin
    ZStream := TDecompressionStream.Create(Buf);
    RE.Lines.LoadFromStream(ZStream);
    ZStream.Free;
  end
  else
    RE.Lines.Clear;
  Buf.Free;
end;
 
procedure TfrmMain.StoreFromFile;
var
  InFile, Buf: TStream;
 
  ZStream: TCustomZLibStream;
begin
 
  if not OD.Execute then
    exit;
  T1.AppendRecord([NULL]);
  InFile := TFileStream.Create(OD.FileName, fmOpenRead);
  Buf := TMemoryStream.Create;
  ZStream := TCompressionStream.Create(clMax, Buf);
  ZStream.CopyFrom(InFile, 0);
  ZStream.Free;
  T1.Edit;
  T1BLOBData.LoadFromStream(Buf);
  T1.Post;
  Buf.Free;
  InFile.Free;
  LID := 0;
  UpdateEditor;
end;
 
procedure TfrmMain.StoreFromEditor;
var
  InStream, Buf: TStream;
 
  ZStream: TCustomZLibStream;
begin
 
  InStream := TMemoryStream.Create;
  Buf := TMemoryStream.Create;
  RE.Lines.SaveToStream(InStream);
  ZStream := TCompressionStream.Create(clMax, Buf);
  ZStream.CopyFrom(InStream, 0);
  ZStream.Free;
  T1.Edit;
  T1BLOBData.LoadFromStream(Buf);
  T1.Post;
  UpdateEditor;
end;
 
procedure TfrmMain.SB1Click(Sender: TObject);
begin
 
  if EF then
  begin
    StoreFromEditor;
    RE.ReadOnly := true;
    DBN.Enabled := true;
    EF := false;
    SB1.Hint := 'Добавить';
  end
  else
    StoreFromFile;
  SetButtons;
end;
 
procedure TfrmMain.SB2Click(Sender: TObject);
begin
 
  if MessageDlg('Удалять запись?', mtConfirmation, [mbYes, mbNo], 0) = mrYes
    then
  begin
    T1.Delete;
    SetButtons;
  end;
end;
 
procedure TfrmMain.SB3Click(Sender: TObject);
begin
 
  DBN.Enabled := false;
  EF := true;
  SB1.Hint := 'Внести изменения';
  RE.ReadOnly := false;
  SetButtons;
end;
 
procedure TfrmMain.SB4Click(Sender: TObject);
begin
 
  UpdateEditor;
  DBN.Enabled := true;
  EF := false;
  SB1.Hint := 'Добавить';
  RE.ReadOnly := true;
end;
 
procedure TfrmMain.DSDataChange(Sender: TObject; Field: TField);
begin
  if assigned(frmMain) and Visible and not EF then
 
  begin
    UpdateEditor;
    SetButtons;
  end;
end;
 
procedure TfrmMain.FormShow(Sender: TObject);
begin
 
  EF := false;
  SetButtons;
  DSDataChange(nil, nil);
end;
 
end.
```

```
// Файл CompBLOB.dpr:
 
program CompBLOB;
uses
 
  Forms,
  Main in 'Main.pas' {frmMain};
 
{$R *.RES}
 
begin
 
  Application.Initialize;
  Application.CreateForm(TfrmMain, frmMain);
  Application.Run;
end.
```

