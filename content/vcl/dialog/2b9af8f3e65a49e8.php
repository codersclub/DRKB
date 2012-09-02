<h1>Как показать File Properties диалог?</h1>
<div class="date">01.01.2007</div>


<pre>
{ This code shows the standard file properties dialog like in Windows Explorer } 
 
uses 
shellapi; 
 
// Thanks to Peter Below (TeamB) for this code 
procedure PropertiesDialog(FileName: string); 
var 
sei: TShellExecuteInfo; 
begin 
FillChar(sei, SizeOf(sei), 0); 
sei.cbSize := SizeOf(sei); 
sei.lpFile := PChar(FileName); 
sei.lpVerb := 'properties'; 
sei.fMask := SEE_MASK_INVOKEIDLIST; 
ShellExecuteEx(@sei); 
end; 
 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
if Opendialog1.Execute then 
PropertiesDialog(Opendialog1.FileName); 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>

