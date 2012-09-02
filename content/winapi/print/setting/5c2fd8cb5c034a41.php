<h1>Как узнать драйвер принтера?</h1>
<div class="date">01.01.2007</div>


<p>Иногда метод GetPrinter() компонента TPrinter возвращает пустую строку, поэтому целесообразно воспользоваться API для получения необходимых параметров из файла Windows.ini.</p>

<pre>
uses Printers;
 
{$IFNDEF WIN32}
const MAX_PATH = 144;
{$ENDIF}
 
procedure TForm1.Button1Click(Sender: TObject);
var
  pDevice: pChar;
  pDriver: pChar;
  pPort: pChar;
  hDMode: THandle;
begin
  if PrintDialog1.Execute then begin
    GetMem(pDevice, cchDeviceName);
    GetMem(pDriver, MAX_PATH);
    GetMem(pPort, MAX_PATH);
    Printer.GetPrinter(pDevice, pDriver, pPort, hDMode);
    if lStrLen(pDriver) = 0 then begin
      GetProfileString('Devices', pDevice, '', pDriver, MAX_PATH);
      pDriver[pos(',', pDriver) - 1] := #0;
    end;
    if lStrLen(pPort) = 0 then begin
      GetProfileString('Devices', pDevice, '', pPort, MAX_PATH);
      lStrCpy(pPort, @pPort[lStrLen(pPort) + 2]);
    end;
    Memo1.Lines.Add('Device := ' + StrPas(pDevice));
    Memo1.Lines.Add('Driver := ' + StrPas(pDriver));
    Memo1.Lines.Add('Port := ' + StrPas(pPort));
    FreeMem(pDevice, cchDeviceName);
    FreeMem(pDriver, MAX_PATH);
    FreeMem(pPort, MAX_PATH);
  end;
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

