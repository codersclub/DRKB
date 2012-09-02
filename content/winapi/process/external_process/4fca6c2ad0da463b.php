<h1>Передача текста любому окну, где стоит фокус</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Timer1Timer(Sender: TObject);

 
var
  pgui: TGUIThreadinfo;
begin
  pgui.cbSize := SizeOf(TGUIThreadinfo);
  GetGUIThreadInfo(GetWindowThreadProcessId(GetForegroundWindow), pgui);
  SendMessage(pgui.hwndFocus, WM_SETTEXT, Length(Edit1.Text), Integer(@Edit1.Text[1]));
end;
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<p class="author">Автор: Rouse_</p>
