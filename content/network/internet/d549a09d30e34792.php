<h1>Как скачать любой URL используя стандартные настройки сети?</h1>
<div class="date">01.01.2007</div>


<p>Начиная с Internet Explorer 3, Microsoft поддерживает очень полезные API, Wininet. Эти функции позволяют использовать все возможности IE, такие как настройки прокси, кэширование файлов и т.д.</p>
<p>Ниже приведён пример использования этих функций для скачивания файла с нужного URL. Это может быть любой доступный URL, ftp://, http://, gopher://, и т.д.</p>
<p>Более подробную информацию об этих функция можно посмотреть в MSDN - Win32 Internet API Functions.</p>
<pre>function DownloadFile(const Url: string): string;
var
  NetHandle: HINTERNET;
  UrlHandle: HINTERNET;
  Buffer: array[0..1024] of char;
  BytesRead: cardinal;
begin
  Result := '';
  NetHandle := InternetOpen('Delphi 5.x', INTERNET_OPEN_TYPE_PRECONFIG, nil, nil, 0);
 
  if Assigned(NetHandle) then
    begin
 
      UrlHandle := InternetOpenUrl(NetHandle, PChar(Url), nil, 0, INTERNET_FLAG_RELOAD, 0);
 
      if Assigned(UrlHandle) then
{ UrlHandle правильный? Начинаем загрузку }
        begin
          FillChar(Buffer, SizeOf(Buffer), 0);
          repeat
            Result := Result + Buffer;
            FillChar(Buffer, SizeOf(Buffer), 0);
            InternetReadFile(UrlHandle, @Buffer, SizeOf(Buffer), BytesRead);
          until BytesRead = 0;
          InternetCloseHandle(UrlHandle);
        end
      else
        begin
{ UrlHandle неправильный. Генерируем исключительную ситуацию. }
          raise Exception.CreateFmt('Cannot open URL %s', [Url]);
        end;
 
      InternetCloseHandle(NetHandle);
    end
  else
{ NetHandle недопустимый. Генерируем исключительную ситуацию }
    raise Exception.Create('Unable to initialize Wininet');
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
