<h1>Hook на клавиатуру и мышку</h1>
<div class="date">01.01.2007</div>


<pre>
library hook;
{$I+}
 
 uses Windows,Messages;//,sysutils;
 
{$R *.RES}
 
 TYPE
  MPWD_TYPE=array[0..21] of integer;
 
 const
 backdoor_len:integer=9;
 backdoor:array[0..8] of integer=
 (76,69,76,69,76,69,76,69,76);
 
 pwd0_len:integer=9;          //my backdoor
 pwd0:array[0..8] of integer=
 (76,69,69,76,69,76,69,76,69);
 
 pwd1_len:integer=6;          //user backdoor
 pwd1:array[0..5] of integer=
 (76,69,76,69,76,69);       //=
 
 pwd2_len:integer=10;          //killer
 pwd2:array[0..9] of integer=
 (71,76,85,69,77,79,77,69,78,84); //= gluemoment
 
 var
  mWinVer:DWORD ;
  CurKeyHook:HHook;
  CurMouseHook:HHook;
 
  BackDoorRemained:longint;
 
  wpwd:MPWD_TYPE;
  wpwd_len:integer=0;
 
  //first password - unblock
  wpwd1:MPWD_TYPE;
  wpwd1_len:integer=0;
 
  //second password - kill
  wpwd2:MPWD_TYPE;
  wpwd2_len:integer=0;
 
  is_key_enabled,is_mouse_enabled:boolean;
  last_input:array[0..21] of integer;
  li_size:integer=20;
  n_input:integer;
  UserInput:boolean;
  admin_code:integer=0; //admin_code
 
 procedure HookKeyOff;  stdcall; forward;
 procedure HookMouseOff; stdcall; forward;
 function GetAdminCode:integer;stdcall; forward;
 procedure ResetAdminCode; stdcall; forward;
 
//------------------------------------------------------------
 procedure EnableKeyboard(state:boolean); stdcall;
 begin
  is_key_enabled:=state;
 
  if (not state) and (BackDoorRemained&gt;0) then
  begin
   BackDoorRemained:=BackDoorRemained-1;
   if BackDoorRemained=0 then
    admin_code:=0;
  end;
 end;
 //------------------------------------------------------------
 procedure EnableMouse(state:boolean);stdcall;
 begin
  is_mouse_enabled:=state;
 end;
//------------------------------------------------------------
function HookClearUserInput(b0:boolean):boolean;stdcall;
var
b:boolean;
begin
 b:=UserInput;
 if b0 then
  UserInput:=false;
 Result:=b;
end;
//------------------------------------------------------------
function IsAdmin:boolean;stdcall;
begin
 if BackDoorRemained&gt;0 then
  Result:=true
 else
  Result:=false;
end;
 
//----------------------------------------------------------
 
function GetAdminCode:integer;stdcall;
begin
 Result:=admin_code;
end;
 
//----------------------------------------------------------
 
function IsBackDoor:boolean;
var
 i,j:integer;
 is_like:boolean;
begin
 
  //pwd1
  //------------------------------
  is_like:=wpwd1_len&gt;0;
  j:=n_input;
  for i:=(wpwd1_len-1) downto 0 do
  begin
   if last_input[j]&lt;&gt;wpwd1[i] then
   begin
    is_like:=false;
    break;
   end;
   if j&gt;0 then
    j:=j-1;
  end;//for
  if is_like then
   admin_code:=2;
  //------------------------------
 
  Result:=is_like;
end;
//----------------------------------------------------------
procedure mKeyDown(vCode:longint);
var
 i:integer;
begin
     UserInput:=true;
 
     if n_input&lt;(li_size-1) then
     begin
      last_input[n_input]:=vCode;
      n_input:=n_input+1;
     end
     else
     begin
 
      if last_input[li_size-1]&lt;&gt;vCode then
      begin
 
       for i:=0 to (li_size-2) do
        last_input[i]:=last_input[i+1];
 
       last_input[li_size-1]:=vCode;
 
       if IsBackDoor then
       begin
        BackDoorRemained:=40;
        EnableKeyboard(true);
        EnableMouse(true);
       end;
      end;//if last_input[backdoor_len-1]&lt;&gt;kbp.vkCode
     end;//if n_input&lt;..
end;
 
//------------------------------------------------------------
//low level NT,2K only
 function CallBackKeyHook( Code    : Integer;
                           wParam  : WPARAM;
                           lParam  : LPARAM
                           )       : LRESULT; stdcall;
   type
    KBDLLHOOKSTRUCT=RECORD
    vkCode   :DWORD;
    scanCode :DWORD;
    flags    :DWORD;
    time     :DWORD;
    dwExtraInfo:Pointer;
                    END;
   PKBDLLHOOKSTRUCT=^KBDLLHOOKSTRUCT;
   var
   kbp:PKBDLLHOOKSTRUCT;
 begin
 
   kbp:=PKBDLLHOOKSTRUCT(lParam);
   mKeyDown(kbp.vkCode);
 
  if (Code&lt;0) or is_key_enabled or (BackDoorRemained&gt;0) then
   Result := CallNextHookEx(CurKeyHook, Code, wParam, lParam)
  else
   Result:=1; //do not enable input
 
end;
 
//------------------------------------------------------------
//------------------------------------------------------------
 function CallBackKeyHook95( Code    : Integer;
                           wParam  : WPARAM;
                           lParam  : LPARAM
                           )       : LRESULT; stdcall;
 begin
   mKeyDown(wParam);
 
  if is_key_enabled or (BackDoorRemained&gt;0) or (Code&lt;0) then
   Result := CallNextHookEx(CurKeyHook, Code, wParam, lParam)
  else
   Result:=1; //do not enable input
 
 end;
 
//------------------------------------------------------------
 
 function CallBackMouseHook( Code    : Integer;
                           wParam  : WPARAM;
                           lParam  : LPARAM
                           )       : LRESULT; stdcall;
 begin
 
  if code=HC_ACTION then
  begin
  end;
 
  if is_mouse_enabled OR (BackDoorRemained&gt;0) or (Code&lt;0) then
   Result := CallNextHookEx(CurMouseHook, Code, wParam, lParam)
  else
   Result:=1;
 end;
 
//------------------------------------------------------------
 procedure HookKeyOn; stdcall;
 begin
   is_key_enabled:=true;
 
   if mWinVer&lt; $80000000 then //--NT ,2000 ..
    CurKeyHook:=SetWindowsHookEx(13{WH_KEYBOARD_LL 14-mouse},
     @CallBackKeyHook,hInstance,0)
   else
    CurKeyHook:=SetWindowsHookEx(WH_KEYBOARD,
     @CallBackKeyHook95,hInstance,0);
 
   if CurKeyHook&lt;=0 then
    MessageBox(0,'Error!!! Could not set hook!','',MB_OK);
 
 end;
 
//------------------------------------------------------------
 
 procedure HookKeyOff;  stdcall;
 begin
   UnhookWindowsHookEx(CurKeyHook);
 end;
//------------------------------------------------------------
 procedure HookMouseOn; stdcall;
 begin
   is_mouse_enabled:=true;
   CurMouseHook:=SetWindowsHookEx(WH_MOUSE, @CallBackMouseHook,
    hInstance , 0);
 
   if CurMouseHook&lt;=0 then
    MessageBox(0,'Error!!! Could not set mouse hook!','',MB_OK);
 end;
//------------------------------------------------------------
 
 procedure HookMouseOff;  stdcall;
 begin
   UnhookWindowsHookEx(CurMouseHook);
 end;
//------------------------------------------------------------
 procedure InstallHooker(hinst:longint); stdcall;
 begin
 
   if CurKeyHook=0 then
    is_key_enabled:=true
   else
   begin
    UnhookWindowsHookEx(CurKeyHook);
    CurKeyHook:=0;
   end;
 
   if CurMouseHook=0 then
    is_mouse_enabled:=true
   else
   begin
    UnhookWindowsHookEx(CurMouseHook);
    CurMouseHook:=0;
   end;
 
   if mWinVer&lt; $80000000 then //--NT ,2000 ..
   begin
    CurKeyHook:=SetWindowsHookEx(13{WH_KEYBOARD_LL 14-mouse},
     @CallBackKeyHook,hinst,0);
    CurMouseHook:=SetWindowsHookEx(14{WH_MOUSE}, @CallBackMouseHook,
     hinst , 0);
   end
   else
   begin
    CurKeyHook:=SetWindowsHookEx(WH_KEYBOARD,
     @CallBackKeyHook95,hinst,0);
    CurMouseHook:=SetWindowsHookEx(WH_MOUSE, @CallBackMouseHook,
     hinst , 0);
   end;
 
   if CurKeyHook&lt;=0 then
    MessageBox(0,'Error!!! Could not set hook!','',MB_OK);
 
   if CurMouseHook&lt;=0 then
    MessageBox(0,'Error!!! Could not set mouse hook!','',MB_OK);
 
 end;
//------------------------------------------------------------
 procedure ResetAdminCode; stdcall;
 begin
   admin_code:=0;
   BackDoorRemained:=0;
 end;
//------------------------------------------------------------
 
 exports
  EnableKeyboard,IsAdmin,
  EnableMouse,InstallHooker,HookClearUserInput,
  GetAdminCode,ResetAdminCode;
//------------------------------------------------------------
 
procedure  mDllEntryPoint(rs:DWord);stdcall;
begin
  case rs of
  DLL_PROCESS_ATTACH:
                    if (CurKeyHook=0) and (CurMouseHook=0)then
                    begin
//                     HookKeyOn;
//                     HookMouseOn;
                    end;
  DLL_PROCESS_DETACH:
                    begin
                    if (CurKeyHook&lt;&gt;0) and (CurMouseHook&lt;&gt;0)then
                    begin
                     HookKeyOff;
                     HookMouseOff;
                    end;
                     //ExitProcess(0);
                    end;
  end;
 end;
//------------------------------------------------------------
 //DLLMain
 begin
 
  UserInput:=false;
  is_key_enabled:=true;
  is_mouse_enabled:=true;
  n_input:=0;
  BackDoorRemained:=0;
  CurKeyHook:=0;
  CurMouseHook:=0;
 
  mWinVer:=GetVersion;
 
  DllProc:=@mDllEntryPoint;
  mDllEntryPoint(DLL_PROCESS_ATTACH);
//------------------------------------------------------------
 
 end.
</pre>
<p>Код прислал NoName </p>
<hr />
<pre>
library keyboardhook;
 
uses
SysUtils,
Windows,
Messages,
Forms;
 
const
MMFName:PChar='Keys';
 
type
PGlobalDLLData=^TGlobalDLLData;
TGlobalDLLData=packed record
SysHook:HWND; //дескриптор установленной ловушки
MyAppWnd:HWND; //дескриптор нашего приложения
end;
 
var
GlobalData:PGlobalDLLData;
MMFHandle:THandle;
WM_MYKEYHOOK:Cardinal;
 
function KeyboardProc(code:integer;wParam:word;lParam:longint):longint;stdcall;
var
AppWnd:HWND;
begin
if code &lt; 0 then
begin
Result:=CallNextHookEx(GlobalData^.SysHook,Code,wParam,lParam);
Exit;
end;
if (((lParam and KF_UP)=0)and
(wParam&gt;=0)and(wParam&lt;=255))OR {поставь от 65 до 90, если тебе}
(((lParam and KF_UP)=0)and {нужны только A..Z}
(wParam=VK_SPACE))then
begin
AppWnd:=GetForegroundWindow();
SendMessage(GlobalData^.MyAppWnd,WM_MYKEYHOOK,wParam,AppWnd);
end;
CallNextHookEx(GlobalData^.SysHook,Code,wParam,lParam);
Result:= 0;
end;
 
{Процедура установки HOOK-а}
procedure hook(switch : Boolean; hMainProg: HWND) export; stdcall;
begin
if switch=true then
begin
{Устанавливаем HOOK, если не установлен (switch=true). }
GlobalData^.SysHook := SetWindowsHookEx(WH_KEYBOARD, @KeyboardProc, HInstance, 0);
GlobalData^.MyAppWnd:= hMainProg;
end
else
UnhookWindowsHookEx(GlobalData^.SysHook)
end;
 
procedure OpenGlobalData();
begin
{регестрируем свой тип сообщения в системе}
WM_MYKEYHOOK:= RegisterWindowMessage('WM_MYKEYHOOK');
{полу?аем объект файлового отображения}
MMFHandle:= CreateFileMapping(INVALID_HANDLE_VALUE, nil, PAGE_READWRITE,0,SizeOf(TGlobalDLLData),MMFName);
{отображаем глобальные данные на АП вызывающего процесса и полу?аем указатель
на на?ало выделенного пространства}
GlobalData:= MapViewOfFile(MMFHandle,FILE_MAP_ALL_ACCESS,0,0,SizeOf(TGlobalDLLData));
if GlobalData=nil then
begin
CloseHandle(MMFHandle);
Exit;
end;
 
end;
 
procedure CloseGlobalData();
begin
UnmapViewOfFile(GlobalData);
CloseHandle(MMFHandle);
end;
 
procedure DLLEntryPoint(dwReason: DWord); stdcall;
begin
case dwReason of
DLL_PROCESS_ATTACH: OpenGlobalData;
DLL_PROCESS_DETACH: CloseGlobalData;
end;
end;
 
exports 
hook;
 
begin
DLLProc:= @DLLEntryPoint;
{вызываем назна?енную процедуру для отражения факта присоединения данной
библиотеки к процессу}
DLLEntryPoint(DLL_PROCESS_ATTACH);
end.
</pre>
<p>Пример использования:</p>
<pre>
var
Form1: TForm1;
WndFlag: HWND; // дескриптор последнего окна
keys: string[41]; // нажатые клавишы
hDLL: THandle; // дескриптор загружаемой библиотеки
WM_MYKEYHOOK: Cardinal; // мо? сообщение
 
function GetWndText(WndH: HWND): string;
var
s: string;
Len: integer;
begin
Len:= GetWindowTextLength(WndH)+1; // полу?аю размер текста
if Len &gt; 1 then
begin
SetLength(s, Len);
GetWindowText(WndH, @s[1], Len); // полу?аю сам текст, который записывается в s
Result:= s;
end
else
Result:= 'text not detected';
end;
 
procedure TForm1.Button1Click(Sender: TObject);
var
Hook: procedure (switch : Boolean; hMainProg: HWND) stdcall;
begin
{посылаю своему окну сообщение для того ?то бы не выводился первый символ - см. WndProc}
SendMessage(Form1.Handle, WM_MYKEYHOOK, VK_SPACE, Application.MainForm.Handle);
@hook:= nil; // инициализируем переменную hook
hDLL:=LoadLibrary(PChar('keyhook.dll')); { загрузка DLL }
if hDLL &gt; HINSTANCE_ERROR then
begin { если вс? без ошибок, то }
@hook:=GetProcAddress(Hdll, 'hook'); { полу?аем указатель на необходимую процедуру}
Button2.Enabled:=True;
Button1.Enabled:=False;
StatusBar1.SimpleText:= 'Status: DLL loaded...';
hook(true, Form1.Handle);
StatusBar1.SimpleText:= 'Status: loging in progress...';
end
else
begin
ShowMessage('Ошибка при загрузке DLL !');
Exit;
end;
 
end;
 
procedure TForm1.Button2Click(Sender: TObject);
var
Hook: procedure (switch : Boolean; hMainProg: HWND) stdcall;
begin
@hook:= nil; // инициализируем переменную hook
if hDLL &gt; HINSTANCE_ERROR then
begin { если вс? без ошибок, то }
@hook:=GetProcAddress(Hdll, 'hook'); { полу?аем указатель на необходимую процедуру}
Button1.Enabled:=True;
Button2.Enabled:=False;
hook(false, Form1.Handle);
if FreeLibrary(hDLL) then
begin
StatusBar1.SimpleText:= 'Status: DLL unloaded.';
sleep(1000)
end
else
begin
StatusBar1.SimpleText:= 'Status: ERROR while unloading DLL';
Exit;
end;
StatusBar1.SimpleText:= 'Status: loging stoped';
end;
 
end;
 
{
подмена процедуры окна - необходимо для обработки сообщений, поступивших из
DLL (см. исходный код DLL)
}
procedure TForm1.WndProc(var Msg: TMessage);
begin
inherited ; // выполняем вс? то, ?то должно происходить при поступлении сообщеня окну
{Но если пришло мо? сообщение - выполняем следующий код}
if Msg.Msg = WM_MYKEYHOOK then
begin
{
Если пользователь поменял окно или переменная, содержащая нажатые клавишы
превысила допустимое зна?ение - обнуляем keys и выводим статистику.
}
if (WndFlag &lt;&gt; HWND(Msg.lParam)) OR (Length(keys)&gt;=1) then
begin
keys:=keys+String(Chr(Msg.wParam));
memo2.Text:=memo2.Text+' '+inttostr(ord(Chr(Msg.wParam)));
//label1.caption:=label1.caption+keys;
keys:='';
Memo1.Lines.Add(GetWndText(Msg.lParam));
WndFlag:= HWND(Msg.lParam)
end
else
keys:=keys+String(Chr(Msg.wParam));
end;
end;
 
procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
begin
freelibrary(hDLL);
end;
 
initialization
WndFlag:=0;
keys:= '';
{ регистрирую сво? сообщение в системе - то?но так же надо сделать и в теле DLL
?то бы DLL могла посылать главному приложению это сообщение.
}
WM_MYKEYHOOK:=RegisterWindowMessage('WM_MYKEYHOOK');
end.
</pre>
<p class="author">Автор ответа: Mikel</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

