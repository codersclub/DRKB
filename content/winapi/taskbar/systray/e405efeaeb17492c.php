<h1>Показываем / Скрываем System Tray</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Ruslan Abu Zant</div>
<p>Вы, наверное, видели множество примеров, которые показывают как скрывать панель задач или кнопку Пуск. Но вот как скрыть только System Tray ?</p>
<pre>procedure hideStartbutton(visi: boolean);
var
  Tray, Child: hWnd;
  C: array[0..127] of Char;
  S: string;
 
begin
  Tray := FindWindow('Shell_TrayWnd', nil);
  Child := GetWindow(Tray, GW_CHILD);
  while Child &lt;&gt; 0 do
    begin
      if GetClassName(Child, C, SizeOf(C)) &gt; 0 then
        begin
          S := StrPAS(C);
          if UpperCase(S) = 'TRAYNOTIFYWND' then
            begin
              if Visi then
                ShowWindow(Child, 1)
              else
                ShowWindow(Child, 0);
            end;
        end;
      Child := GetWindow(Child, GW_HWNDNEXT);
    end;
end;
</pre>

<p>для того, чтобы обатно её показать, используйте</p>
<p>hideStartbutton(true);</p>
<p>или hideStartbutton(false);</p>
<p>чтобы скрыть !!</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
