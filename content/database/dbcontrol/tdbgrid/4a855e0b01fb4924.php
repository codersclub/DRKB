<h1>Текущая строка и поле в TDBGrid</h1>
<div class="date">01.01.2007</div>


<pre>
unit dbcolform;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls, Grids, DBGrids, DB, DBTables;
 
type
  TForm1 = class(TForm)
    Table1: TTable;
    DataSource1: TDataSource;
    DBGrid1: TDBGrid;
    Label1: TLabel;
    procedure DBGrid1ColEnter(Sender: TObject);
    procedure DataSource1DataChange(Sender: TObject; Field: TField);
  private
    { Private declarations }
  public
    { Public declarations }
  end;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.DFM}
 
type
  TFake = class (TDBGrid);
 
procedure TForm1.DBGrid1ColEnter(Sender: TObject);
begin
  Label1.Caption := Format (
    'Column: %2d; Row: %2d',
    [TFake (DbGrid1).Col,
    TFake (DbGrid1).Row]);
end;
 
procedure TForm1.DataSource1DataChange(Sender: TObject; Field: TField);
begin
  DBGrid1ColEnter (sender);
end;
 
end.
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
