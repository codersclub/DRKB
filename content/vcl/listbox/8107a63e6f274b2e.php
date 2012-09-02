<h1>Как создать поле Lookup во время выполнения приложения?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  Forms, Classes, Controls, StdCtrls, Db, DBTables, DBCtrls; 
 
 
type 
  TForm1 = class(TForm) 
    Table1: TTable;   // DBDemos customer table 
    Table2: TTable;   // DBDemos orders table 
    Button1: TButton; 
    DBLookupComboBox1: TDBLookupComboBox; 
    DataSource1: TDataSource; 
    Table2CustNo: TFloatField;  // CustNo key field object used for Lookup   
    procedure Button1Click(Sender: TObject); 
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
  with TStringField.Create(Table2) do begin 
    FieldName := 'MyLookup'; 
    FieldKind:= fkLookup; 
    DataSet := Table2;   
    Name := Dataset.Name + FieldName; 
    KeyFields:= 'CustNo'; 
    LookUpDataset:= Table1; 
    LookUpKeyFields:= 'CustNo'; 
    LookUpResultField:= 'Company'; 
    DbLookupCombobox1.DataField:= FieldName; 
    DataSource1.DataSet:= Dataset; 
    Table2.FieldDefs.Add(Name, ftString, 20, false); 
  end; 
  DbLookupCombobox1.DataSource:= Datasource1; 
  Table1.Active:= True; 
  Table2.Active:= True; 
end; 
 
end.
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

