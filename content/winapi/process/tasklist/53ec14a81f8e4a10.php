<h1>Как определить, какие приложения уже запущены?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Button1Click(Sender: TObject);
VAR
Wnd : hWnd;
buff: ARRAY [0..127] OF Char;
begin
ListBox1.Clear;
Wnd := GetWindow(Handle, gw_HWndFirst);
WHILE Wnd &lt;&gt; 0 DO 
BEGIN {Не показываем:}
IF (Wnd &lt;&gt; Application.Handle) AND {-Собственное окно}
IsWindowVisible(Wnd) AND {-Невидимые окна}
(GetWindow(Wnd, gw_Owner) = 0) AND {-Дочернии окна}
(GetWindowText(Wnd, buff, sizeof(buff)) &lt;&gt; 0) {-Окна без заголовков}
THEN BEGIN
GetWindowText(Wnd, buff, sizeof(buff));
ListBox1.Items.Add(StrPas(buff));
END;
Wnd := GetWindow(Wnd, gw_hWndNext);
END;
ListBox1.ItemIndex := 0;
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

