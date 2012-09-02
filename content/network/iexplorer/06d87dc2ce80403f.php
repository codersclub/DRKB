<h1>Удалить временные файлы IE</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  WinInet; 
 
procedure DeleteIECache; 
var 
  lpEntryInfo: PInternetCacheEntryInfo; 
  hCacheDir: LongWord; 
  dwEntrySize: LongWord; 
begin 
  dwEntrySize := 0; 
  FindFirstUrlCacheEntry(nil, TInternetCacheEntryInfo(nil^), dwEntrySize); 
  GetMem(lpEntryInfo, dwEntrySize); 
  if dwEntrySize &gt; 0 then lpEntryInfo^.dwStructSize := dwEntrySize; 
  hCacheDir := FindFirstUrlCacheEntry(nil, lpEntryInfo^, dwEntrySize); 
  if hCacheDir &lt;&gt; 0 then  
  begin 
    repeat 
      DeleteUrlCacheEntry(lpEntryInfo^.lpszSourceUrlName); 
      FreeMem(lpEntryInfo, dwEntrySize); 
      dwEntrySize := 0; 
      FindNextUrlCacheEntry(hCacheDir, TInternetCacheEntryInfo(nil^), dwEntrySize); 
      GetMem(lpEntryInfo, dwEntrySize); 
      if dwEntrySize &gt; 0 then lpEntryInfo^.dwStructSize := dwEntrySize; 
    until not FindNextUrlCacheEntry(hCacheDir, lpEntryInfo^, dwEntrySize); 
  end; 
  FreeMem(lpEntryInfo, dwEntrySize); 
  FindCloseUrlCache(hCacheDir); 
end; 
 
 
// Beispiel: 
// Example: 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  DeleteIECache; 
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
