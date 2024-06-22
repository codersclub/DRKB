---
Title: Удалить временные файлы IE
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Удалить временные файлы IE
==========================

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
      if dwEntrySize > 0 then lpEntryInfo^.dwStructSize := dwEntrySize; 
      hCacheDir := FindFirstUrlCacheEntry(nil, lpEntryInfo^, dwEntrySize); 
      if hCacheDir <> 0 then  
      begin 
        repeat 
          DeleteUrlCacheEntry(lpEntryInfo^.lpszSourceUrlName); 
          FreeMem(lpEntryInfo, dwEntrySize); 
          dwEntrySize := 0; 
          FindNextUrlCacheEntry(hCacheDir, TInternetCacheEntryInfo(nil^), dwEntrySize); 
          GetMem(lpEntryInfo, dwEntrySize); 
          if dwEntrySize > 0 then lpEntryInfo^.dwStructSize := dwEntrySize; 
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

