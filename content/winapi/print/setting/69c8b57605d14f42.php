<h1>Как получить разрешение принтера по умолчанию?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  Printers; 
 
function GetPixelsPerInchX: Integer; 
begin 
  Result := GetDeviceCaps(Printer.Handle, LOGPIXELSX) 
end; 
 
function GetPixelsPerInchY: Integer; 
begin 
  Result := GetDeviceCaps(Printer.Handle, LOGPIXELSY) 
end; 
 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  Caption := Format('x: %d y: %d DPI (dots per inch)', 
                   [GetPixelsPerInchX, GetPixelsPerInchY]); 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
