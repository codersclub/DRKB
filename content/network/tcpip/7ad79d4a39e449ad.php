<h1>Смена IP-адреса</h1>
<div class="date">01.01.2007</div>


<pre>
{ Programmed Malomush Vladimir. Ukraine, Cherkassy vovs@neocm.com
 IP tools unit for set IP and Mask of network connection fo Win9X &amp; NT Platforms
}
unit Iptools;
 
interface
uses Windows,Registry,SysUtils, Variants, Classes,Dialogs,ShellApi;
//-----------------------------------------------------
  var
 Registry1: Tregistry;
 Keyslist:  Tstrings;
 P: Pointer;
//Declarations-----------------------------------------
Procedure Set_IP_AND_MASK98(IP,Mask: String);
Procedure Set_IP_AND_MASKXP(IP,Mask: String);
Procedure Set_IP_AND_MASK (IP,Mask: String);
function GetWinVersion: String;
 
implementation
function GetWinVersion: String;
var
   VersionInfo : TOSVersionInfo;
   OSName      : String;
begin
      VersionInfo.dwOSVersionInfoSize := SizeOf( TOSVersionInfo );
 
   if Windows.GetVersionEx( VersionInfo ) then
      begin
         with VersionInfo do
         begin
            case dwPlatformId of
               VER_PLATFORM_WIN32s   : OSName := 'Win32s';
               VER_PLATFORM_WIN32_WINDOWS : OSName := 'Windows 95';
               VER_PLATFORM_WIN32_NT      : OSName := 'Windows NT';
            end; // case dwPlatformId
           // Result := OSName + ' Version ' + IntToStr( dwMajorVersion ) + '.' + IntToStr( dwMinorVersion ) +
             //         #13#10' (Build ' + IntToStr( dwBuildNumber ) + ': ' + szCSDVersion + ')';
             Result:= OSName;
         end; // with VersionInfo
      end // if GetVersionEx
   else
      Result := '';
end;
 
//--------- Procedure for windowsXP -------------------
Procedure Set_IP_AND_MASKXP(IP,Mask: String);
 var
 i,NumDev: integer;
 p: Pchar;
 s: string;
begin
//Initialization----------------------------------------
s:='netsh interface ip set address "Подключение по локальной сети" source=static addr='+IP+' mask='+Mask;
p:=pchar(s);
WinExec( @p[0], sw_show);
beep;
end;
 
//--------- Procedure for windows98 -------------------
Procedure Set_IP_AND_MASK98(IP,Mask: String);
 var
 i,NumDev: integer;
begin
  //Initialization----------------------------------------
  Keyslist:=TstringList.Create;
  Registry1:=TRegistry.Create;
  //Detect net devices------------------------------------
  Registry1.RootKey:= hkey_local_machine;
  Registry1.OpenKey('System\CurrentControlSet\Services\Class\Net',True);
  Registry1.GetKeyNames(Keyslist);
  Registry1.CloseKey;
  //Detect phisical net device-----------------------------
  For I:=0 to KeysList.Count-1 do
   Begin
    Registry1.OpenKey('System\CurrentControlSet\Services\Class\Net\'+KeysList.Strings[i],True);
    If Registry1.ValueExists('IOBaseAddress')=True Then NumDev:=I;
    Registry1.CloseKey;
   End;
 //Open device  &amp; set setings------------------------------
 Registry1.OpenKey('System\CurrentControlSet\Services\Class\NetTrans\'+KeysList.Strings[NumDev],True);
 Registry1.WriteString('IPAddress',IP);
 Registry1.WriteString('IPMask',Mask);
 Registry1.CloseKey;
 //Deinitialization--------------------------------------
 Registry1.Free;
 Keyslist.Free;
 Beep;
 MessageDlg('Все изменения вступят в силу только после перезагрузки.', mtInformation, [mbOk], 0);
end;
 
Procedure Set_IP_AND_MASK (IP,Mask: String);
 var s: string;
begin
  S:=GetWinVersion;
  if S='Windows 95' Then Set_IP_AND_MASK98(IP,Mask);
  if S='Windows NT' Then Set_IP_AND_MASKXP(IP,Mask);
end;
 
end.
</pre>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<div class="author">Автор: vovs</div>
