<h1>Частота мигания каретки</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  Label1.Caption := Format('Caret blink time is: %d ms', [GetCaretBlinkTime]);
end;
 
 
procedure TForm1.Button2Click(Sender: TObject);
begin
  // Set caret blink time to 2000ms
  SetCaretBlinkTime(2000);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
