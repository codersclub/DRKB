<h1>Как мне отправить на принтер чистый поток данных?</h1>
<div class="date">01.01.2007</div>


<p>Под Win16 Вы можете использовать функцию SpoolFile, или</p>
<p>Passthrough escape, если принтер поддерживает последнее.</p>
<p>Под Win32 Вы можете использовать WritePrinter.</p>

<p>'иже пример открытия принтера и записи чистого потока данных в принтер.</p>
<p>Учтите, что Вы должны передать корректное имя принтера, такое, как "HP LaserJet</p>
<p>5MP",</p>
<p>чтобы функция сработала успешно.</p>

<p>Конечно, Вы можете включать в поток данных любые необходимые управляющие коды,</p>

<p>которые могут потребоваться.</p>

<pre>
uses WinSpool;
 
procedure WriteRawStringToPrinter(PrinterName:String; S:String);
var
  Handle: THandle;
  N: DWORD;
  DocInfo1: TDocInfo1;
begin
  if not OpenPrinter(PChar(PrinterName), Handle, nil) then
  begin
    ShowMessage('error ' + IntToStr(GetLastError));
    Exit;
  end;
  with DocInfo1 do begin
    pDocName := PChar('test doc');
    pOutputFile := nil;
    pDataType := 'RAW';
  end;
  StartDocPrinter(Handle, 1, @DocInfo1);
 
  StartPagePrinter(Handle);
  WritePrinter(Handle, PChar(S), Length(S), N);
  EndPagePrinter(Handle);
  EndDocPrinter(Handle);
  ClosePrinter(Handle);
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  WriteRawStringToPrinter('HP', 'Test This');
end;
</pre>


<p>(Borland FAQ N714, переведен Акжаном Абдулиным)</p>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
