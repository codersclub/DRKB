<h1>Проблемы INI-файла</h1>
<div class="date">01.01.2007</div>


<p>Кто-нибудь имел какие-нибудь проблемы при использовании модуля TIniFile? Я думаю здесь какая-то детская проблема с кэшированием!!! </p>
<p>Вот что я делал:</p>
<pre>
(* c:\test.ini уже существует *)
myIni := TIniFile.Create('c:\test.ini');
With myIni do
begin
  // .... (добавляем новую секцию в test.ini
end;
myIni.Free;
RenameFile('c:\test.ini', 'c:\test1.ini');
</pre>

<p>Что я получил: </p>
<p>test1.ini НЕ ИМЕЕТ добавленной мною секции; </p>
<p>всякий раз при создании или открытии нового файла в том же самом каталоге с помощью File Manager, 'c:\test.ini' появляется вновь, и у него СУЩЕСТВУЕТ секция, которую я добавлял.</p>
<p>Я решил эту проблему добавлением следующей строки перед IniFile.Free:</p>
<p>WritePrivateProfileString(nil, nil, nil, PChar(IniFileName)); </p>
<p>Для получения дополнительной информации обратитесь к электронной справке к разделу 'WritePrivateProfileString'</p>
<p class="author">Автор: Tony Chang </p>
&nbsp;</p>
<hr /><p>Как указать системе на необходимость сбросить буфер INI-файла на диск</p>
<pre>
procedure FlushIni(FileName: string);
var
  {$IFDEF WIN32}
  CFileName: array[0..MAX_PATH] of WideChar;
  {$ELSE}
  CFileName: array[0..127] of Char;
  {$ENDIF}
begin
  {$IFDEF WIN32}
  if (Win32Platform = VER_PLATFORM_WIN32_NT) then
    WritePrivateProfileStringW(nil, nil, nil, StringToWideChar(FileName,
    CFileName, MAX_PATH))
  else
    WritePrivateProfileString(nil, nil, nil, PChar(FileName));
  {$ELSE}
  WritePrivateProfileString(nil, nil, nil, StrPLCopy(CFileName,
  FileName, SizeOf(CFileName) - 1));
  {$ENDIF}
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
