<h1>Как выбрать случайную запись?</h1>
<div class="date">01.01.2007</div>



<pre>
procedure TForm1.FormCreate(Sender: TObject); 
begin 
  Randomize; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  Table1.First; 
  Table1.MoveBy(Random(Table1.RecordCount)); 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
