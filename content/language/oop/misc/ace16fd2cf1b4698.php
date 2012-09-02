<h1>Список handle всех окон моего приложения</h1>
<div class="date">01.01.2007</div>


<pre>
function EnumProc(wnd: HWND; var count: DWORD): Bool; stdcall;
begin
  Inc(count);
  result := True;
  EnumChildWindows(wnd, @EnumProc, integer(@count));
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  count: DWORD;
begin
  count := 0;
  EnumThreadWindows(GetCurrentThreadID, @EnumProc, Integer(@count));
  Caption := Format('%d window handles in use', [count]);
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
