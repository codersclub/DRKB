---
Title: Пример очистки куков и Temporarily Internet Files
Author: Rouse\_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Пример очистки куков и Temporarily Internet Files
===============================================

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

