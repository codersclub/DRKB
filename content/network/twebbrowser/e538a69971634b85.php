<h1>Как скрыть контекстное меню TWebBrowser?</h1>
<div class="date">01.01.2007</div>


<pre>
var 
  HookID: THandle; 
 
function MouseProc(nCode: Integer; wParam, lParam: Longint): Longint; stdcall; 
var 
  szClassName: array[0..255] of Char; 
const 
  ie_name = 'Internet Explorer_Server'; 
begin 
  case nCode &lt; 0 of 
    True: 
      Result := CallNextHookEx(HookID, nCode, wParam, lParam) 
      else 
        case wParam of 
          WM_RBUTTONDOWN, 
          WM_RBUTTONUP: 
            begin 
              GetClassName(PMOUSEHOOKSTRUCT(lParam)^.HWND, szClassName, SizeOf(szClassName)); 
              if lstrcmp(@szClassName[0], @ie_name[1]) = 0 then 
                Result := HC_SKIP 
              else 
                Result := CallNextHookEx(HookID, nCode, wParam, lParam); 
            end 
            else 
              Result := CallNextHookEx(HookID, nCode, wParam, lParam); 
        end; 
  end; 
end; 
 
procedure TForm1.FormCreate(Sender: TObject); 
begin 
  HookID := SetWindowsHookEx(WH_MOUSE, MouseProc, 0, GetCurrentThreadId()); 
end; 
 
procedure TForm1.FormDestroy(Sender: TObject); 
begin 
  if HookID &lt;&gt; 0 then 
    UnHookWindowsHookEx(HookID); 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  Webbrowser1.Navigate('http://www.google.com'); 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
