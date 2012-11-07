<h1>Как вшить иконку в мою прогу с нуля?</h1>
<div class="date">01.01.2007</div>


<p>в .RC - файле подключаемом к проекту пишешь<br>
<p></p>
<pre>100 ICON "100.ico"
</pre>
<p> <br>
<p>для загрузки икоки:</p>
<pre>
  with MainWindow do
  begin

 
    cbSize := SizeOf(MainWindow);
    style := CS_HREDRAW or CS_VREDRAW;
    lpfnWndProc := @WindowProc;
    cbClsExtra := 0;
    cbWndExtra := 0;
    hIcon := LoadIcon(0, IDI_APPLICATION);
    hCursor  := LoadCursor(0, IDC_ARROW);
    hbrBackground := COLOR_BTNFACE + 1;
    lpszMenuName := nil;
    lpszClassName := 'TDeliveryInstaller';
  end;
  MainWindow.hInstance := HInstance;
  if RegisterClassEx(MainWindow) = 0 then Exit;
 
  Width := 360;
  Height := 200;
 
  InitCommonControls;
 
  Handle := CreateWindowEx(0, 'TDeliveryInstaller',
    PChar(TXT_CAPTION), WS_OVERLAPPED or WS_SYSMENU,
    Left, Top, Width, Height, 0, 0, HInstance, nil);
 
  SendMessage(Handle, WM_SETICON, 1, LoadIcon(HInstance, MAKEINTRESOURCE(100)));
</pre>
<p> <br>
<div class="author">Автор: Rouse_</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

