<h1>Как очистить буфер клавиатуры?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure EmptyKeyQueue;
var
  msg: TMsg;
begin
  while PeekMessage(msg, 0, WM_KEYFIRST, WM_KEYLAST, PM_REMOVE or PM_NOYIELD) do
    ;
end;
 
begin
  EmptyKeyQueue;
end.
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
