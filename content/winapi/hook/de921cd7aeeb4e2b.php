<h1>Создание мышиного перехватчика</h1>
<div class="date">01.01.2007</div>


<pre>
library Hookdemo;
 
uses
 
Beeper in '\DELDEMOS\HOOKDEMO\BEEPER.PAS';
 
exports
 
SetHook index 1,
UnHookHook index 2,
HookProc index 3;
 
begin
 
HookedAlready:=False;
end.
</pre>

<p>, где beeper.pas содержит следующий код:</p>
<pre>unit Beeper;
 
interface
 
uses Wintypes, Winprocs, Messages;
 
function SetHook: Boolean; export;
function UnHookHook: Boolean; export;
function HookProc(Code: integer; wParam: Word;
  lParam: Longint): Longint; export;
 
var
  HookedAlready: Boolean;
 
implementation
 
var
  ourHook: HHook;
 
function SetHook: Boolean;
begin
  if HookedAlready then
    exit;
  ourHook := SetWindowsHookEx(WH_MOUSE, HookProc, HInstance, 0);
  HookedAlready := True;
end;
 
function UnHookHook: Boolean;
begin
  UnHookWindowsHookEx(ourHook);
  HookedAlready := False;
end;
 
function HookProc(Code: integer; wParam: Word;
  lParam: Longint): Longint;
begin
  if (wParam = WM_LBUTTONDOWN) then
    MessageBeep(0);
  result := CallNextHookEx(ourHook, Code, wParam, lParam);
end;
 
end.
</pre>

<p>Теперь, при вызове из приложения функции SetHook, при каждом нажатии левой кнопки мыши будет раздаваться сигнал - до тех пор, пока вы не вызовете функцию UnHookHook. В действующем приложении возвращаемое функцией CallNextHookEx значение &lt; 0 сведетельствует об отсутствии манипуляций с мышью.</p>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
