<h1>Как запретить кнопку Close в любом окне?</h1>
<div class="date">01.01.2007</div>


<p>Следующий пример запрещает кнопку закрытия (и пункт "закрыть" (close) в системном меню) нужного нам окна (в данном случае Notepad).</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject); 
var 
  hwndHandle : THANDLE; 
  hMenuHandle : HMENU; 
begin 
  hwndHandle := FindWindow(nil, 'Untitled - Notepad'); 
  if (hwndHandle &lt;&gt; 0) then begin 
    hMenuHandle := GetSystemMenu(hwndHandle, FALSE); 
    if (hMenuHandle &lt;&gt; 0) then 
      DeleteMenu(hMenuHandle, SC_CLOSE, MF_BYCOMMAND); 
  end; 
end; 
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
