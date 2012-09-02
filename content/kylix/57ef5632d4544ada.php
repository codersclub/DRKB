<h1>Как запустить другое приложение?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  libc; 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  iPrg: Integer; 
begin 
  //Execute kcalc - A calculator for KDE 
  iPrg := libc.system('kcalc'); 
  if iPrg = -1 then 
    ShowMessage('Error executing your program'); 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
