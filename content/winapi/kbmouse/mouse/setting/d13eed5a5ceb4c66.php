<h1>Как прочитать и изменить doubleclick time?</h1>
<div class="date">01.01.2007</div>


<pre>
// Set example:
procedure TForm1.Button1Click(Sender: TObject);
begin
  // will reset after system start
  SetDoubleClickTime(1500);
end;
 
// Get example:
procedure TForm1.Button2Click(Sender: TObject);
begin
  ShowMessage(IntToStr(GetDoubleClickTime));
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
