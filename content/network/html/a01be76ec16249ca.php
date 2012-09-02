<h1>Показать код HTML страницы в TMemo</h1>
<div class="date">01.01.2007</div>


<pre>
// You need a TMemo, a TButton and a NMHTTP
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  NMHTTP1.Get('www.swissdelphicenter.ch'); 
  memo1.Text := NMHTTP1.Body 
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
