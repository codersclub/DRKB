<h1>Как выровнять иконки на рабочем столе к левому краю?</h1>
<div class="date">01.01.2007</div>


<p>Для начала необходимо получить дескриптор рабочего стола, который представляет из себя обычный ListView.</p>
<p>Пример:</p>
<pre>function GetDesktopListViewHandle: THandle;
var
S: String;
begin
Result := FindWindow('ProgMan', nil);
Result := GetWindow(Result, GW_CHILD);
Result := GetWindow(Result, GW_CHILD);
SetLength(S, 40);
GetClassName(Result, PChar(S), 39);
if PChar(S) &lt;&gt; 'SysListView32' then Result := 0;
end;
</pre>

<p>Как только дескриптор рабочего стола получен, можно с ним работать при помощи обычных API функций (через юнит CommCtrl). См. сообщения LVM_xxxx в хелпе по Win32.</p>
<p>Следующая строчка кода выравнивает иконки на рабочем столе к левому краю:</p>
<p>SendMessage(GetDesktopListViewHandle,LVM_ALIGN,LVA_ALIGNLEFT,0);</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
