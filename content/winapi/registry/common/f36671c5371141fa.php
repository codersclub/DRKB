<h1>Экспорт и импорт из реестра</h1>
<div class="date">01.01.2007</div>

reg-файлы это, как и ожидалось, формат, понимаемый и поддерживаемый сугубо программой regedit. </p>
<p>Командная строка у неё такая: </p>
<p>Импорт в реестр: </p>
<pre>regedit RegData.reg
</pre>
<p>Экспорт из реестра: </p>
<pre>regedit /e RegData.reg HKEY_LOCAL_MACHINE\Software\Microsoft\Windows
</pre>
<p>Если в параметрах встречаются пробелы, их ессно надо заключать в кавычки. Код в Delphi, который экспортирует ветвь реестра может быть например такой: </p>
<pre>
uses
  ShellApi;
 
procedure TMain.ExportBtnClick(Sender: TObject);
var
  FileName, Key: string;
begin
  FileName := ... //заполнить именем файла (расширение указывать)
  Key := ... //заполнить именем ключа, типа
  //Key := 'HKEY_LOCAL_MACHINE\Software\Microsoft\Windows NT\CurrentVersion'
  if ShellExecute(Handle, 'open', 'regedit.exe',
  PChar(Format('/e "%s" "%s"', [FileName, Key])),
  '', SW_SHOWDEFAULT) &lt;= 32
  then //если ошибка, то возвращаемый код &lt;=32
    RaiseLastWin32Error();
end;
</pre>


