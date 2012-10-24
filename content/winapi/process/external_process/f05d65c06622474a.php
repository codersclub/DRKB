<h1>Получить текст окна, где этого не может WM_GETTEXT</h1>
<div class="date">01.01.2007</div>


<p>Она может брать текст, где этого не может делать GetWindowText(), вот собственно и все!</p>
<p>Должна работать и в win98, но небыло возможности проверить.... =)</p>
<p>Так что кому надо... Отделбное спасибо .alex'у</p>
<pre>
 
program pGrabber;
 
uses
  windows,
  myfuncs in 'myfuncs.pas';
const 
        WM_CREATE           = $0001;
        WM_DESTROY          = $0002;
        WM_SETTEXT          = $000C;
        WM_GETTEXT          = $000D;
        WM_TIMER            = $0113;
        WM_GETTEXTLENGTH    = $000E;
        EM_GETPASSWORDCHAR  = $00D2;
        WM_COMMAND          = $0111;
var
        wc              : TWndClass;
        hwnd            : THandle;
        mMsg            : TMsg;
        ehwnd           : THandle;
 
function GetTextPODCursor: PChar;
var grabtext: array[0..125] of char;
    lpPoint: TPoint;
    hwnd: THandle;
begin
   GetCursorPos(lpPoint);
   hwnd := WindowFromPoint(lpPoint);
   if (SendMessage(hwnd, EM_GETPASSWORDCHAR, 0, 0) &lt;&gt; 0) then
      begin
       SendMessage(hwnd, WM_GETTEXT, 20, Integer(PChar(@grabtext)));
       result := PChar(@grabtext);
      end else
   result := PChar('');
   SendMessage(ehwnd, WM_SETTEXT, 0, Integer(result));
end;
 
 
//////////////////////
// Main Window Proc //
//////////////////////
function WndProc(hwnd: Thandle; lMsg, wParam, lParam: LongInt): LongInt; stdcall;
begin
   Case lMsg of
     WM_CREATE:
        begin
            SetWindowPos(hwnd,HWND_TOPMOST,0,0,0,0,SWP_NOSIZE + SWP_NOMOVE);
            SetTimer(hwnd, 55555, 2*1000, nil);
        end;
 
     WM_TIMER:
        begin
            if (not IsNT)then GetTextPODCursor else SpawnThreadNT('EXPLORER.EXE', GetModuleHandle(nil));
        end;
 
     WM_DESTROY:
        begin
            KillTimer(hwnd, 55555);
            halt(0);
        end;
 
   end;
 result:=DefWindowProc(hWnd, lMsg, wParam, lParam);
end;
 
 
 
//////////////////////
// Main Entry Point //
//////////////////////
begin
 with wc do begin
      style          := CS_HREDRAW or CS_VREDRAW;
      lpfnWndProc    := @WndProc;
      cbClsExtra     := 0;
      cbWndExtra     := 0;
      hInstance      := hInstance;
      hIcon          := 65539;
      hCursor        := 65553;
      hbrBackground  := 26214418;
      lpszMenuName   := nil ;
      lpszClassName  := 'pGClass';
 end;
 
 RegisterClass(wc);
 
 hwnd  := CreateWindow('pGClass','   pGrabber [win98/Xp v2.0]  by xZero',WS_OVERLAPPEDWINDOW and WS_DLGFRAME,400,300,260,65,0,0,hInstance,nil);
 ehwnd := CreateWindowEx(WS_EX_CLIENTEDGE, 'Edit', '',WS_CHILD or WS_VISIBLE or ES_READONLY, 5, 5, 245, 20, hwnd, 0, hInstance, nil);
 
 ShowWindow(hwnd, SW_SHOW);UpdateWindow(hwnd);
 
 while GetMessage(mMsg, hwnd , 0, 0) do
  begin
   TranslateMessage(mMsg);
   DispatchMessage(mMsg);
  end;
  Halt(mMsg.wParam);
end.
</pre>

<pre>
unit myfuncs;
interface
uses windows, tlhelp32;
        function IsNT: boolean;
        function OPTHDROFFSET(ptr: LongInt): DWORD;
        function SpawnThreadNT(pszProcess: PChar; g_hModule: HMODULE): boolean;
        procedure EntryPoint;
 
 
implementation
const 
        EM_GETPASSWORDCHAR  = $00D2;
        WM_SETTEXT          = $000C;
        WM_GETTEXT          = $000D;
 
function IsNT: boolean;
var
        osvi:   OSVERSIONINFO;
begin
    osvi.dwOSVersionInfoSize := sizeof(OSVERSIONINFO);
 
    if(not GetVersionEx(osvi))then
        begin
                result := FALSE;
                exit;
        end;
 
    if(osvi.dwPlatformId &lt;&gt; VER_PLATFORM_WIN32_NT)then
        result := FALSE
    else
        result := TRUE;
end;
 
 
function OPTHDROFFSET(ptr: LongInt): DWORD;
begin
        result := PImageOptionalHeader(int64(ptr) + PImageDosHeader(ptr)._lfanew + sizeof(DWORD) + sizeof(IMAGE_FILE_HEADER)).SizeOfImage;
end;
 
 
function SpawnThreadNT(pszProcess: PChar; g_hModule: HMODULE): boolean;
var
        dwProcID: DWORD;
        hToolHelp: THandle;
    pe: PROCESSENTRY32;
        hProc: THandle;
        dwSize: DWORD;
        pMem: Pointer;
    dwOldProt, dwNumBytes, i: DWORD;
        mbi: TMemoryBasicInformation;
        dwRmtThdID: DWORD;
        hRmtThd: THandle;
begin
    hToolHelp := CreateToolhelp32Snapshot(TH32CS_SNAPPROCESS, 0);
    pe.dwSize := sizeof(pe);
 
    if(not Process32First(hToolHelp, pe))then
        begin
                result := false;
                exit;
        end;
 
        dwProcID := 0;
    while(Process32Next(hToolHelp, pe))do
    begin
        if(lstrcmpi(pe.szExeFile, pszProcess) = 0)then
        begin
            dwProcID := pe.th32ProcessID;
            break;
        end;
 
    end;
 
    if(dwProcID = 0)then
    begin
        result := FALSE;
                exit;
    end;
 
    if(GetCurrentProcessId() = dwProcID)then
        begin
                result := FALSE;
                exit;
        end;
 
 
    hProc := OpenProcess(PROCESS_ALL_ACCESS, FALSE, dwProcID);
    if(hProc = 0)then
    begin
        result := FALSE;
                exit;
    end;
 
    VirtualFreeEx(hProc, ptr(g_hModule), 0, MEM_RELEASE);
 
    dwSize := OPTHDROFFSET(g_hModule);
 
    pMem := VirtualAllocEx(hProc, ptr(g_hModule), dwSize, MEM_COMMIT or MEM_RESERVE, PAGE_EXECUTE_READWRITE);
    if(pMem = nil)then
    begin
        result := FALSE;
                exit;
    end;
 
    VirtualQueryEx(hProc, pMem, mbi, sizeof(MEMORY_BASIC_INFORMATION));
    while((mbi.Protect &lt;&gt; PAGE_NOACCESS) and (mbi.RegionSize &lt;&gt; 0))do
        begin
        if((mbi.Protect and PAGE_GUARD) = 0)then
        begin
                        i := 0;
                        while(i &lt; mbi.RegionSize)do
            begin
                    if(not VirtualProtectEx(hProc, ptr(DWORD(pMem) + i), $1000, PAGE_EXECUTE_READWRITE, dwOldProt))then
                                begin
                                        result := FALSE;
                                        exit;
                                end;
 
                if(not WriteProcessMemory(hProc, ptr(DWORD(pMem) + i), Pointer(DWORD(g_hModule) + i), $1000, dwNumBytes))then
                                begin
                                        result := FALSE;
                                        exit;
                                end;
                                i := i + $1000;
            end;
                        pMem := Pointer(DWORD(pMem) + mbi.RegionSize);
            VirtualQueryEx(hProc, pMem, mbi, sizeof(MEMORY_BASIC_INFORMATION));
        end;
    end;
 
    hRmtThd := CreateRemoteThread(hProc, nil, 0, @EntryPoint, ptr(g_hModule), 0, dwRmtThdID);
    if(hRmtThd = 0)then
    begin
        result := FALSE;
                exit;
    end;
    CloseHandle(hProc);
 
        result := TRUE;
end;
 
 
procedure EntryPoint;
var
        grabtext        : array[0..125] of char;
        lpPoint         : TPoint;
        hwnd            : THandle;
begin
   GetCursorPos(lpPoint);
   hwnd := WindowFromPoint(lpPoint);
   if (GetParent(hwnd) &lt;&gt; 0)then
   begin
        SendMessage(hwnd, WM_GETTEXT, 20, Integer(PChar(@grabtext)));
        SendMessage(FindWindowEx(FindWindow('pGClass', nil), 0, 'Edit', nil), WM_SETTEXT, 0, Integer(PChar(@grabtext)));
   end;
end;
 
end.
</pre>
<div class="author">Автор: x2er0</div>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

