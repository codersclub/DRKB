<h1>Как открыть диалог смены системного времени?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  Shellapi; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  ShellExecute(Handle, 'open', 'control', 'date/time', nil, SW_SHOW); 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

