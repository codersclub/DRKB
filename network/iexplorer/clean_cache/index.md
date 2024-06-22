---
Title: Как очистить кэш в IE?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как очистить кэш в IE?
======================

В примере описывается как программно в Internet Explorer нажать кнопку
"Clear cache".

Вам нужно будет использовать WinINet в Вашей TfrmMain:

    Uses WinINet; 

и добавить к TButton следующий обработчик btnEmptyCache:

    Procedure TfrmMain.btnEmptyCacheClick( Sender : TObject ); 
    Var 
        lpEntryInfo : PInternetCacheEntryInfo; 
        hCacheDir   : LongWord; 
        dwEntrySize : LongWord; 
        dwLastError : LongWord; 
    Begin 
        dwEntrySize := 0; 
        FindFirstUrlCacheEntry( NIL, TInternetCacheEntryInfo( NIL^ ), dwEntrySize ); 
        GetMem( lpEntryInfo, dwEntrySize ); 
        hCacheDir := FindFirstUrlCacheEntry( NIL, lpEntryInfo^, dwEntrySize ); 
        If ( hCacheDir <> 0 ) Then 
            DeleteUrlCacheEntry( lpEntryInfo^.lpszSourceUrlName ); 
        FreeMem( lpEntryInfo ); 
        Repeat 
            dwEntrySize := 0; 
            FindNextUrlCacheEntry( hCacheDir, TInternetCacheEntryInfo( NIL^ ), dwEntrySize ); 
            dwLastError := GetLastError(); 
            If ( GetLastError = ERROR_INSUFFICIENT_BUFFER ) Then Begin 
                GetMem( lpEntryInfo, dwEntrySize ); 
                If ( FindNextUrlCacheEntry( hCacheDir, lpEntryInfo^, dwEntrySize ) ) Then 
                    DeleteUrlCacheEntry( lpEntryInfo^.lpszSourceUrlName ); 
                FreeMem(lpEntryInfo); 
            End; 
        Until ( dwLastError = ERROR_NO_MORE_ITEMS ); 
    End;

