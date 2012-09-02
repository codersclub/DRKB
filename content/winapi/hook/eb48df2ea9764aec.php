<h1>Глобальный хук на клавиатуру</h1>
<div class="date">01.01.2007</div>


<pre>
library Hook;
uses Windows, SysUtils;
const KF_UP_MY = $40000000;
var CurrentHook: HHook;
    KeyArray: array[0..19] of char;
    KeyArrayPtr: integer;
    CurFile:text;
function GlobalKeyBoardHook(code: integer; wParam: integer; lParam:
integer): longword; stdcall;
var
i:integer;
begin
  if code&lt; 0 then
   begin
     result:=CallNextHookEx(CurrentHook,code,wParam,lparam);
     Exit;
   end;
  if ( (lParam and KF_UP_MY ) = 0) and (wParam&gt; =65) and (wParam&lt; =90) then
    begin
      KeyArray[KeyArrayPtr]:=char(wParam);
      KeyArrayPtr:=KeyArrayPtr+1;
      if KeyArrayPtr&gt; 19 then
       begin
        for i:=0 to 19 do
        begin
          Assignfile(CurFile,'d:\log.txt');
          if fileexists('d:\log.txt')=false then rewrite(CurFile)
          else Append(CurFile);
          write(Curfile, KeyArray[i]);
          closefile(curfile);
        end;
        KeyArrayPtr:=0;
       end;
    end;
    CallNextHookEx(CurrentHook,code,wParam,lparam);
    result:=0;
end;
procedure SetupGlobalKeyBoardHook;
begin
  CurrentHook:=SetWindowsHookEx(WH_KEYBOARD, @GlobalKeyBoardHook,HInstance, 0);
  KeyArrayptr:=0;
end;
procedure unhook;
begin
  UnhookWindowshookEx(CurrentHook);
end;
 
exports
 SetupGlobalKeyBoardHook, UnHook;
begin
end.
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
