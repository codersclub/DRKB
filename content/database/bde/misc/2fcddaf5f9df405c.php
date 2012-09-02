<h1>Как ускорить поиск?</h1>
<div class="date">01.01.2007</div>


<pre>
type
  TForm1 = class(TForm)
    DataSource1: TDataSource;
    Table1: TTable;
    Button1: TButton;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  SeekValue: string;
begin
  Table1.DisableControls;
  Table1.FindKey([SeekValue]);
  Table1.EnableControls;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
