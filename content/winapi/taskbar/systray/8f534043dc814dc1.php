<h1>Надпись на часах в трее</h1>
<div class="date">01.01.2007</div>


<pre>
var
  hTrayClock  : HWND;
  DC:HDC;
  r:TRect;

begin
  hTrayClock := FindWindowEx(FindWindowEx(FindWindow('Shell_TrayWnd',nil),0,'TrayNotifyWnd',nil),0,'TrayClockWClass',nil);
  GetWindowRect(hTrayClock,r);
  DC := GetDC(0);
//  SetBkMode(DC, TRANSPARENT);   // можно сделать прозрачный фон
  SetTextColor(DC, RGB($0FF,0,0));
  SetBkColor(DC,RGB($0FF,$0FF,0));
  TextOut(DC, r.Left+((r.Right-r.Left) div 4), r.Top+((r.Bottom-r.Top) div 4), '&gt;:-(', 4);
  ReleaseDC(hTrayClock, DC);
end.
</pre>
<p>При следующем обновлении часов надпись исчезнет. Так что можно делать это по таймеру.<br>
<p></p>
<div class="author">Автор: Krid</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
