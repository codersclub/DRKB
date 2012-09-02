<h1>Как открыть диалог добавления принтера?</h1>
<div class="date">01.01.2007</div>


<pre>
// добавьте ShellAPI в USES
 
begin
  ShellExecute(handle, nil, 'rundll32.exe',
    'shell32.dll,SHHelpShortcuts_RunDLL AddPrinter',
    '', SW_SHOWNORMAL);
end;
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
