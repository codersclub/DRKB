<h1>Удаление каталога с подкаталогами</h1>
<div class="date">01.01.2007</div>


<p>Способ 1: проход по дереву каталогов (Функция для удаления каталогов, взята из рассылки "Мастера DELPHI. Новости мира компонент, FAQ, статьи..." - собственно код аналогичен написанному мной коду по рекурсивному проходу каталогов <a href="b81.htm">здесь</a>) </p>
<pre>
Function MyRemoveDir(sDir : String) : Boolean;
var
iIndex : Integer;
SearchRec : TSearchRec; 
sFileName : String; 
<p>begin 
Result := False; 
sDir := sDir + '\*.*'; 
iIndex := FindFirst(sDir, faAnyFile, SearchRec); 
while iIndex = 0 do 
begin 
sFileName := ExtractFileDir(sDir)+'\'+SearchRec.Name; 
if SearchRec.Attr = faDirectory then 
begin 
if (SearchRec.Name &lt;&gt; '' ) and (SearchRec.Name &lt;&gt; '.') and (SearchRec.Name &lt;&gt; '..') then MyRemoveDir(sFileName); 
end 
else 
begin 
if SearchRec.Attr &lt;&gt; faArchive then FileSetAttr(sFileName, faArchive); 
if NOT DeleteFile(sFileName) then ShowMessage('Could NOT delete ' + sFileName); 
end; 
iIndex := FindNext(SearchRec); 
end; 
FindClose(SearchRec); 
RemoveDir(ExtractFileDir(sDir)); 
Result := True; 
end;
</pre>

<p>Способ 2: Использование ShellApi</p>
<pre>uses ShellApi;
...
var sh : SHFILEOPSTRUCT;
begin
...
sh.Wnd := Application.Handle;
sh.wFunc := FO_DELETE;
sh.pFrom := 'c:\\test\0';
sh.pTo := nil;
sh.fFlags := FOF_NOCONFIRMATION or FOF_SILENT;
sh.hNameMappings := nil;
sh.lpszProgressTitle := nil;
 
SHFileOperation (sh);
... 
 
</pre>
<p>Надо путь писать : c:\\test\dfg</p>
<p>Чтобы вначале "\\" было...иначе не будет удалять диры из корня </p>
<p class="author">Автор ответа: Baa </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
