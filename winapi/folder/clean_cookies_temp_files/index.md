---
Title: Пример очистки куков и Temporaly Internet Files
Author: Rouse\_
Date: 01.01.2007
---


Пример очистки куков и Temporaly Internet Files
===============================================

::: {.date}
01.01.2007
:::

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
        if dwEntrySize > 0 then lpEntryInfo^.dwStructSize := dwEntrySize; 
        hCacheDir := FindFirstUrlCacheEntry(nil, lpEntryInfo^, dwEntrySize); 
        if hCacheDir <> 0 then  
        try
          repeat 
            DeleteUrlCacheEntry(lpEntryInfo^.lpszSourceUrlName); 
            FreeMem(lpEntryInfo, dwEntrySize); 
            dwEntrySize := 0; 
            FindNextUrlCacheEntry(hCacheDir, TInternetCacheEntryInfo(nil^), dwEntrySize); 
            GetMem(lpEntryInfo, dwEntrySize); 
            if dwEntrySize > 0 then lpEntryInfo^.dwStructSize := dwEntrySize; 
          until not FindNextUrlCacheEntry(hCacheDir, lpEntryInfo^, dwEntrySize); 
        finally
          FindCloseUrlCache(hCacheDir); 
        end; 
      finally
        FreeMem(lpEntryInfo, dwEntrySize); 
      end;
    end;

Автор: Rouse\_

Взято из <https://forum.sources.ru>
