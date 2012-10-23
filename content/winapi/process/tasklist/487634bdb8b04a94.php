<h1>Как определить, откуда был запущен процесс?</h1>
<div class="date">01.01.2007</div>


<p>Есть handle запущенного PE файла. Как определить откуда он был запущен?</p>
<p>Я так предполагаю что getmodulefilename как и GetModuleHandle</p>
<p>работает в рамках только своего процесса.</p>
<p>А решить твою задачу .. можно так:</p>
<p>Тут парочка моих любимых функций</p>
<pre>
uses
tlhelp32;
 
type
TModuleArray = array of TModuleEntry32;
 
// Возвращает список описаний (TModuleEntry32) модулей по идентификатору процесса 
function GetModulesListByProcessId(ProcessId : Cardinal) : TModuleArray;
 
implementation
 
function GetModulesListByProcessId(ProcessId : Cardinal) : TModuleArray;
var
hSnapshot : THandle;
lpme : TModuleEntry32;
 
procedure AddModuleToList;
begin
SetLength(Result,High(Result)+2);
Result[high(Result)]:=lpme;
end;
 
begin
SetLength(Result,0);
hSnapshot:=CreateToolhelp32Snapshot(TH32CS_SNAPMODULE,ProcessId);
if hSnapshot=-1 then RaiseLastWin32Error;
lpme.dwSize:=SizeOf(lpme);
if Module32First(hSnapshot,lpme) then
begin
AddModuleToList;
while Module32Next(hSnapshot,lpme) do AddModuleToList;
end;
end;
 
</pre>
<pre>
VAR Wnd : hWnd;
buff: ARRAY [0..127] OF Char;
//------------------------------------
Pid : Cardinal;
modarr : TModuleArray;
Name : String;
//------------------------------------
begin
StringGrid1.RowCount:=1;
Wnd := GetWindow(Handle, gw_HWndFirst);
WHILE Wnd &lt;&gt; 0 DO
BEGIN 
IF (GetWindowText(Wnd, buff, sizeof(buff)) &lt;&gt; 0) THEN 
BEGIN
fillchar(name,sizeof(name),#0); 
GetWindowText(wnd,buff,sizeof(buff));
// if getmodulefilename(GetWindowLong(wnd,GWL_HINSTANCE),name,sizeof(name))=0
// then name:='Null';
//-----------------------------------------
GetWindowThreadProcessId(Wnd,@Pid);
modarr:=GetModulesListByProcessId(Pid);
name:='Null';
for i:=0 to High(modarr) do
begin
if Integer(modarr[i].modBaseAddr)=$400000 then
begin
name:=modarr[i].szExePath;
break;
end;
end; 
//-----------------------------------------
StringGrid1.Cells[0,StringGrid1.RowCount-1]:=StrPas(buff);
StringGrid1.Cells[1,StringGrid1.RowCount-1]:=StrPas(name);
StringGrid1.RowCount:=StringGrid1.RowCount+1;
END;
Wnd := GetWindow(Wnd, gw_hWndNext);
END;
StringGrid1.RowCount:=StringGrid1.RowCount-1;
end; 
</pre>

<div class="author">Автор: TAPAKAH</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
