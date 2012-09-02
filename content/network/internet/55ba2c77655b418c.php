<h1>Как узнать размер файла в интернете?</h1>
<div class="date">01.01.2007</div>


<pre>
uses wininet;
...
function GetUrlSize(const URL:string):integer;//результат в байтах
var
  hSession,hFile:hInternet;
  dwBuffer:array[1..20] of char;
  dwBufferLen,dwIndex:DWORD;
begin
Result:=0;
hSession:=InternetOpen('GetUrlSize',INTERNET_OPEN_TYPE_PRECONFIG,nil,nil,0);
if Assigned(hSession) then begin
 hFile:=InternetOpenURL(hSession,PChar(URL),nil,0,INTERNET_FLAG_RELOAD,0);
 dwIndex:=0;
 dwBufferLen:=20;
 if HttpQueryInfo(hFile,HTTP_QUERY_CONTENT_LENGTH,@dwBuffer,dwBufferLen,dwIndex) then Result:=StrToInt(StrPas(@dwBuffer));
 if Assigned(hFile) then InternetCloseHandle(hFile);
 InternetCloseHandle(hsession);
end;
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<p class="author">Автор: P.O.D.</p>
