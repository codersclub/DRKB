<h1>Как скрыть часики в панели задач?</h1>
<div class="date">01.01.2007</div>


<p>Убираем часики:</p>
<pre>procedure TForm1.Button1Click(Sender: TObject);
var hn: HWnd;
begin
  hn := FindWindowEx(FindWindowEx(FindWindow('Shell_TrayWnd', nil), 0, 'TrayNotifyWnd', nil), 0, 'TrayClockWClass', nil); 
  if hn &lt;&gt; 0 then
    ShowWindow(hn, SW_HIDE); //Bye,bye,Baby
end;
</pre>
<p>Снова показываем:</p>
<pre>procedure TForm1.Button2Click(Sender: TObject);
var hn: HWnd;
begin
  hn := FindWindowEx(FindWindowEx(FindWindow('Shell_TrayWnd', nil), 0, 'TrayNotifyWnd', nil), 0, 'TrayClockWClass', nil);
  if hn &lt;&gt; 0 then
    ShowWindow(hn, SW_SHOW); //Hello, again
end;
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
function ShowTrayClock(bValue: Boolean) : Boolean; 
var 
  TrayWnd, TrayNWnd, ClockWnd: HWND; 
begin 
  TrayWnd  := FindWindow('Shell_TrayWnd', nil); 
  TrayNWnd := FindWindowEx(TrayWnd, 0, 'TrayNotifyWnd', nil); 
  ClockWnd := FindWindowEx(TrayNWnd, 0, 'TrayClockWClass', nil); 
  Result := IsWindow(ClockWnd); 
  if Result then 
  begin 
    ShowWindow(ClockWnd, Ord(bValue)); 
    PostMessage(ClockWnd, WM_PAINT, 0, 0); 
  end; 
end; 
 
// Example to hide they clock: 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
   ShowTrayClock(Boolean(0)); 
end;
</pre>



<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
