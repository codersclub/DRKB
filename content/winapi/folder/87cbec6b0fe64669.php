<h1>Пример очистки куков и Temporaly Internet Files</h1>
<div class="date">01.01.2007</div>


<pre>
uses ..., WinInet;

 
procedure DeleteCache; 
var 
  lpEntryInfo: PInternetCacheEntryInfo; 
  hCacheDir: LongWord; 
  dwEntrySize: LongWord; 
begin 
  dwEntrySize := 0; 
  FindFirstUrlCacheEntry(nil, TInternetCacheEntryInfo(nil^), dwEntrySize); 
  GetMem(lpEntryInfo, dwEntrySize); 
  try
    if dwEntrySize &gt; 0 then lpEntryInfo^.dwStructSize := dwEntrySize; 
    hCacheDir := FindFirstUrlCacheEntry(nil, lpEntryInfo^, dwEntrySize); 
    if hCacheDir &lt;&gt; 0 then  
    try
      repeat 
        DeleteUrlCacheEntry(lpEntryInfo^.lpszSourceUrlName); 
        FreeMem(lpEntryInfo, dwEntrySize); 
        dwEntrySize := 0; 
        FindNextUrlCacheEntry(hCacheDir, TInternetCacheEntryInfo(nil^), dwEntrySize); 
        GetMem(lpEntryInfo, dwEntrySize); 
        if dwEntrySize &gt; 0 then lpEntryInfo^.dwStructSize := dwEntrySize; 
      until not FindNextUrlCacheEntry(hCacheDir, lpEntryInfo^, dwEntrySize); 
    finally
      FindCloseUrlCache(hCacheDir); 
    end; 
  finally
    FreeMem(lpEntryInfo, dwEntrySize); 
  end;
end;
</pre>
<div class="author">Автор: Rouse_</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
