<h1>Как установить драйвер принтера?</h1>
<div class="date">01.01.2007</div>


<p>Приведенный пример устанавливает драйвер принтера. Вам необходимо скопировать файлы с драйвером принтера в каталог Windows\System и внести необходимые изменения в файл Win.Ini.</p>

<p class="note">Примечание:</p>

<p>DriverName = Имя драйвера;</p>
<p>DRVFILE - имя файла с драйвером без расширения (".drv" - по умолчанию).</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  s: array [0..64] of char;
begin
  WriteProfileString('PrinterPorts', 'DriverName', 'DRVFILE,FILE:,15,45');
  WriteProfileString('Devices', 'DriverName', 'DRVFILE,FILE:');
  StrCopy(S, 'PrinterPorts');
  SendMessage(HWND_BROADCAST, WM_WININICHANGE, 0, LongInt(@S));
  StrCopy(S, 'Devices');
  SendMessage(HWND_BROADCAST, WM_WININICHANGE, 0, LongInt(@S));
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

