<h1>Пример процедуры, убивающей таймеры по заголовку окна в чужих приложениях, написанных на Delphi</h1>
<div class="date">01.01.2007</div>


<pre>
var
 Hinst : THandle;
 WndArr : array of THandle;
 Wnd : THandle;
 
......
 
Procedure KillDelphiWndTimers(const AppCaption:string);
var  i : integer;
function GetTimerWindows(Handle: HWND; Info: Pointer): BOOL; stdcall;
const
sClName ='TPUtilWindow';
var
s : String;
begin
Result := True;
SetLength(s,Length(sClName)+1);
GetClassName(Handle, PChar(s),Length(s));
SetLength(s,Length(sClName)); // E?aeo caieoeaaou neaie #0 :)
if (GetWindowLong(Handle, GWL_HINSTANCE) =  Hinst )  and  (s=sClName)
then
  begin
    SetLength(WndArr,High(WndArr)+2);
    WndArr[High(WndArr)]:=Handle;
  end;
end;
 
begin
Wnd:=FindWindow(nil,Pchar(AppCaption));
if Wnd=0 then Exit;
hinst:=GetWindowLong(Wnd, GWL_HINSTANCE);
EnumWindows(@GetTimerWindows,0);
for i:=0 to High(WndArr) do KillTimer(WndArr[i],1);
end;
</pre>

<p class="author">Автор: Radmin</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
