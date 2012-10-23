<h1>Как очистить кэш в IE?</h1>
<div class="date">01.01.2007</div>


<p>В примере описывается как программно в Internet Explorer нажать кнопку "Clear cache".</p>
<p>Вам нужно будет использовать WinINet в Вашей TfrmMain:</p>
<pre>
Uses WinINet; 
</pre>
<p>и добавить к TButton следующий обработчик btnEmptyCache:</p>

<pre>
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
    If ( hCacheDir &lt;&gt; 0 ) Then 
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
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
