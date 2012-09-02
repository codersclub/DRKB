<h1>Как проверить существование URL?</h1>
<div class="date">01.01.2007</div>


<p>Данная функция позволяет Вам проверить существование определённого адреса(URL) в интернете. Естественно она может пригодиться веб-мастерам, у которых на сайте много ссылок, и необходимо с определённой периодичнойстью эти ссылки проверять. </p>
<p>URL может быть как с префиксом http:/ так и без него - эта функция добавляет префикс http:// если он отсутствует (необходимо для функции internetOpenUrl которая так же поддерживает FTP:// и gopher:// </p>
<p>Эта функция проверяет только два возвращаемых кода '200'(ОК) или '302' (Редирект), но Вы можете заставить проверять функцию и другие коды. Для этого достаточно модифицировать строчку "result := ". </p>
<p>Платформа: Delphi 3.x (или выше)</p>
<pre>
uses wininet;
 
function CheckUrl(url: string): boolean;
var
  hSession, hfile, hRequest: hInternet;
  dwindex, dwcodelen: dword;
  dwcode: array[1..20] of char;
  res: pchar;
begin
  if pos('http://', lowercase(url)) = 0 then
    url := 'http://' + url;
  Result := false;
  hSession := InternetOpen('InetURL:/1.0',
    INTERNET_OPEN_TYPE_PRECONFIG, nil, nil, 0);
  if assigned(hsession) then
    begin
      hfile := InternetOpenUrl(
        hsession,
        pchar(url),
        nil,
        0,
        INTERNET_FLAG_RELOAD,
        0);
      dwIndex := 0;
      dwCodeLen := 10;
      HttpQueryInfo(hfile, HTTP_QUERY_STATUS_CODE,
        @dwcode, dwcodeLen, dwIndex);
      res := pchar(@dwcode);
      result := (res = '200') or (res = '302');
      if assigned(hfile) then
        InternetCloseHandle(hfile);
      InternetCloseHandle(hsession);
    end;
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
