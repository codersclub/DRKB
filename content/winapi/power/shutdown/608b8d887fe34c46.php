<h1>Как выключить, перезагрузить или завершить Windows?</h1>
<div class="date">01.01.2007</div>



<pre>
function MyExitWindows(RebootParam: Longword): Boolean; 
var 
  TTokenHd: THandle; 
  TTokenPvg: TTokenPrivileges; 
  cbtpPrevious: DWORD; 
  rTTokenPvg: TTokenPrivileges; 
  pcbtpPreviousRequired: DWORD; 
  tpResult: Boolean; 
const 
  SE_SHUTDOWN_NAME = 'SeShutdownPrivilege'; 
begin 
  if Win32Platform = VER_PLATFORM_WIN32_NT then 
  begin 
    tpResult := OpenProcessToken(GetCurrentProcess(), 
      TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY, 
      TTokenHd); 
    if tpResult then 
    begin 
      tpResult := LookupPrivilegeValue(nil, 
                                       SE_SHUTDOWN_NAME, 
                                       TTokenPvg.Privileges[0].Luid); 
      TTokenPvg.PrivilegeCount := 1; 
      TTokenPvg.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED; 
      cbtpPrevious := SizeOf(rTTokenPvg); 
      pcbtpPreviousRequired := 0; 
      if tpResult then 
        Windows.AdjustTokenPrivileges(TTokenHd, 
                                      False, 
                                      TTokenPvg, 
                                      cbtpPrevious,
                                      rTTokenPvg,
                                      pcbtpPreviousRequired);
    end;
  end;
  Result := ExitWindowsEx(RebootParam, 0);
end;
 
// Example to shutdown Windows:
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  MyExitWindows(EWX_POWEROFF or EWX_FORCE);
end;
 
// Example to reboot Windows:
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  MyExitWindows(EWX_REBOOT or EWX_FORCE);
end;
</pre>

<hr />
<p>{2. Console Shutdown Demo}</p>

<pre>
program Shutdown;
{$APPTYPE CONSOLE}
 
uses 
  SysUtils, 
  Windows; 
 
// Shutdown Program 
// (c) 2000 NeuralAbyss Software 
// www.neuralabyss.com 
 
var 
  logoff: Boolean = False; 
  reboot: Boolean = False; 
  warn: Boolean = False; 
  downQuick: Boolean = False; 
  cancelShutdown: Boolean = False; 
  powerOff: Boolean = False; 
  timeDelay: Integer = 0; 
 
function HasParam(Opt: Char): Boolean; 
var 
  x: Integer; 
begin 
  Result := False; 
  for x := 1 to ParamCount do 
    if (ParamStr(x) = '-' + opt) or (ParamStr(x) = '/' + opt) then Result := True; 
end; 
 
function GetErrorstring: string; 
var 
  lz: Cardinal; 
  err: array[0..512] of Char; 
begin 
  lz := GetLastError; 
  FormatMessage(FORMAT_MESSAGE_FROM_SYSTEM, nil, lz, 0, @err, 512, nil); 
  Result := string(err); 
end; 
 
procedure DoShutdown; 
var 
  rl, flgs: Cardinal; 
  hToken: Cardinal; 
  tkp: TOKEN_PRIVILEGES; 
begin 
  flgs := 0; 
  if downQuick then flgs := flgs or EWX_FORCE; 
  if not reboot then flgs := flgs or EWX_SHUTDOWN; 
  if reboot then flgs := flgs or EWX_REBOOT; 
  if poweroff and (not reboot) then flgs := flgs or EWX_POWEROFF; 
  if logoff then flgs := (flgs and (not (EWX_REBOOT or EWX_SHUTDOWN or EWX_POWEROFF))) or 
      EWX_LOGOFF; 
  if Win32Platform = VER_PLATFORM_WIN32_NT then 
  begin 
    if not OpenProcessToken(GetCurrentProcess, TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY, 
      hToken) then 
      Writeln('Cannot open process token. [' + GetErrorstring + ']') 
    else 
    begin 
      if LookupPrivilegeValue(nil, 'SeShutdownPrivilege', tkp.Privileges[0].Luid) then 
      begin 
        tkp.Privileges[0].Attributes := SE_PRIVILEGE_ENABLED; 
        tkp.PrivilegeCount           := 1; 
        AdjustTokenPrivileges(hToken, False, tkp, 0, nil, rl); 
        if GetLastError &lt;&gt; ERROR_SUCCESS then 
          Writeln('Error adjusting process privileges.'); 
      end 
      else 
        Writeln('Cannot find privilege value. [' + GetErrorstring + ']'); 
    end; 
    {   if CancelShutdown then 
          if AbortSystemShutdown(nil) = False then 
            Writeln(\'Cannot abort. [\' + GetErrorstring + \']\') 
          else 
           Writeln(\'Cancelled.\') 
       else 
       begin 
         if InitiateSystemShutdown(nil, nil, timeDelay, downQuick, Reboot) = False then 
            Writeln(\'Cannot go down. [\' + GetErrorstring + \']\') 
         else 
            Writeln(\'Shutting down!\'); 
       end; 
    } 
  end; 
  //     else begin 
  ExitWindowsEx(flgs, 0); 
  //     end; 
end; 
 
begin 
  Writeln('Shutdown v0.3 for Win32 (similar to the Linux version)'); 
  Writeln('(c) 2000 NeuralAbyss Software. All Rights Reserved.'); 
  if HasParam('?') or (ParamCount = 0) then 
  begin 
    Writeln('Usage:    shutdown [-akrhfnc] [-t secs]'); 
    Writeln('                  -k:      do not really shutdown, only warn.'); 
    Writeln('                  -r:      reboot after shutdown.'); 
    Writeln('                  -h:      halt after shutdown.'); 
    Writeln('                  -p:      power off after shutdown'); 
    Writeln('                  -l:      log off only'); 
    Writeln('                  -n:      kill apps that do not want to die.'); 
    Writeln('                  -c:      cancel a running shutdown.'); 
  end 
  else 
  begin 
    if HasParam('k') then warn := True; 
    if HasParam('r') then reboot := True; 
    if HasParam('h') and reboot then 
    begin 
      Writeln('Error: Cannot specify -r and -h parameters together!'); 
      Exit; 
    end; 
    if HasParam('h') then reboot := False; 
    if HasParam('n') then downQuick := True; 
    if HasParam('c') then cancelShutdown := True; 
    if HasParam('p') then powerOff := True; 
    if HasParam('l') then logoff := True; 
    DoShutdown; 
  end; 
end.
</pre>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
<hr />Для выполнения перезагрузки/выключения предназначены функции ExitWindows/ExitWindowsEx</p>

<p>ExitWindows:</p>

<p>Описание:</p>
<p> Function ExitWindows(Reserved: DWord; ReturnCode: Word): Bool;</p>
<p> Иницииpует стандаpтную пpоцедуpу завеpшения pаботы с Windows. Все пpикладные задачи должны подтвеpдить завеpшение pаботы Windows. Вызывает функцию 4CH пpеpывания 21H DOS.</p>

<p>Паpаметpы:</p>
<p> Reserved: Установлен в нуль.</p>
<p> ReturnCode: Значение, пеpедаваемое в DOS (в pегистpе AL).</p>

<p>Возвpащаемое значение:</p>
<p> Нуль, если одна или несколько задач отказываются завеpшить pаботу.</p>

<p>Примеры использования:</p>
<p> ExitWindows(EWX_LOGOFF,0); - завершение сеанса</p>
<p> ExitWindows(EWX_SHUTDOWN,0); - выключение компьютера</p>
<p> ExitWindows(EWX_REBOOT,0); - перезагрузка</p>
<p> Флаги EWX_FORCE, EWX_POWEROFF и&nbsp; EWX_FORCEIFHUNG могут комбинироваться к нужному действию.</p>

<p>ExitWindowsEx:</p>
<p>Функция ExitWindowsEx() представляет собой расширенный вариант ExitWindows().</p>

<p>Описание:</p>
<p> BOOL ExitWindowsEx( UINT uFlags, DWORD dwReserved, ); </p>
<p> Функция ExitWindowsEx перезагружает(restart) или выключает систему (shutdown), а также может завершить сессию для текущего пользователя(log off). </p>

<p>Параметры:</p>
<p> uFlags -- флаг завершения работы, может принимать следущие значения:</p>
<p> &nbsp; EWX_LOGOFF завершает сессию текущего пользователя.</p>
<p> &nbsp; EWX_POWEROFF выключает питание компьютера(компьютер должен поддерживать данную функцию).</p>
<p> &nbsp; EWX_REBOOT перезагружает систему. </p>
<p> &nbsp; EWX_SHUTDOWN завершает работу комьпьютера до того места, где он может быть безопасно выключен: сброшенны все файловые буферы на диск, завершает работу всех процессов. </p>
<p> dwReserved --Зарезирвированно для последующих нужд, параметр игнорируется. </p>

<p>Возвращаемое значение:</p>
<p> Не ноль если всё прошло успешно </p>

<p>Пример использования:</p>
<p> ExitWindowsEx(EWX_SHUTDOWN,0);</p>
<p> Остальные примеры смотри в описании первой функции.</p>

<p>Вышеописанные примеры действительны только для w9x/Me.</p>
<p>Дело в том, что, чтобы выполнить функциию в NT ОС, нужно получить права на выполнение этой функции. Сделать это можно через AdjustTokenPriviligies.</p>
<p>С помощью нижеприведённой функции можно получить любую привелегию, в т.ч. и привеленгию SeShutdownPrivilege, которая нужна для разрешения функции ExitWindows(Ex)</p>

<pre>
Function SetPrivilege(aPrivilegeName: String; aEnabled: Boolean ): Boolean; 
Var TPPrev, 
      TP: TTokenPrivileges; 
      Token: THandle; 
      dwRetLen: DWord; 
Begin 
 Result:=False; 
 OpenProcessToken(GetCurrentProcess,TOKEN_ADJUST_PRIVILEGES or TOKEN_QUERY, @Token ); 
 TP.PrivilegeCount:=1; 
 IF LookupPrivilegeValue(nil,PChar(aPrivilegeName),TP.Privileges[0].LUID )) then 
  Begin 
   IF aEnabled then TP.Privileges[0].Attributes:=SE_PRIVILEGE_ENABLED 
              else  TP.Privileges[0].Attributes:=0; 
   dwRetLen:= 0; 
   Result:=AdjustTokenPrivileges(Token,False,TP,SizeOf(TPPrev),TPPrev,dwRetLen); 
  End; 
 CloseHandle(Token); 
End;
</pre>


<p>Пример использования для среды NT:</p>

<p> SetPrivilege('SeShutdownPrivilege',True);</p>
<p> ExitWindowsEx(EWX_SHUTDOWN,0);</p>
<div class="author">Автор: Song</div>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

