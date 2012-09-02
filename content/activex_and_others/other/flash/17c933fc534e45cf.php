<h1>Определить, установлен ли Adobe Flash</h1>
<div class="date">01.01.2007</div>


<pre>
program SeekFlash;
 
 uses
   Forms, Windows, INIFiles, SysUtils, Dialogs, ShellApi;
 
 {$R *.RES}
 
 type
   TVersionInfo = record
     dwSignature,
     dwStrucVersion,
     dwFileVersionMS,
     dwFileVersionLS,
     dwProductVersionMS,
     dwProductVersionLS,
     dwFileFlagsMask,
     dwFileFlags,
     dwFileOS,
     dwFileType,
     dwFileSubtype,
     dwFileDateMS,
     dwFileDateLS: DWORD;
   end;
 
 
 var
   //Reg:TRegistry; 
  Ini: TIniFile;
   Text: array[1..4] of string;
 
   AppPath, IniFile, MySec: string;
   SetupFile, RunFile, SetupClass: string;
 
   VersionStr, BrowserStr: string;
 
   {RegSubKey,} OpenBrowser, PlugInName, UseExt: string;
   MainVersion: Word;
   // FoundOne :Boolean; 
 
  PVer, DPchar, POpenBrowser: PChar;
   MyPoint: Pointer;
   PLen: Cardinal;
   version: ^TVersionInfo;
   DumD: DWORD;
   LWord, HWord: Word;
 
   CheckHandle: Hwnd;
 
   //--------------------------- 
  //Gets the Plugin (file-) Version 
  //--------------------------- 
procedure GetVersion(pluginName: string);
 begin
   DPChar := StrAlloc(255);
   DPchar := PChar(PluginName);
 
   PVer := StrAlloc(getFileVersionInfoSize(DPchar, Plen));
   getFileVersionInfo(DPChar, 0, 255, PVer);
   VerQueryValue(Pver, '\', MyPoint, Plen);
 
   Version := myPoint;
 
   dumD  := Version.dwFileVersionMS;
   hword := dumD shr 16;
   lword := dumD and 255;
 
   MainVersion := hword;
   VersionStr  := IntToStr(Hword) + '.' + IntToStr(LWord);
 
   dumD  := Version.dwFileVersionLs;
   hword := dumD shr 16;
   lword := dumD and 255;
 
   versionStr := versionStr + '.' + IntToStr(Hword) + '.' + IntToStr(lWord);
 end;
 
 begin
   appPath := extractFileDir(Application.exeName);
 
 
   // runFile:= 'test.htm'; 
  //runFile must be a html File to determin wich browser(NC or IE) is used 
  POpenBrowser := StrAlloc(255);
   FindExecutable(PChar(extractFileName(runFile)),
     PChar(extractFileDir(runFile)), POpenBrowser);
   OpenBrowser := POpenBrowser;
 
   if not Fileexists(openBrowser) then
   begin
     MessageDlg(Text[4], mtInformation, [mbOK], 0);
     halt;
   end;
 
 
   //set the FileLocations for Netscape or IE 
  if Pos('NETSCAPE.EXE', uppercase(trim(OpenBrowser))) &lt;&gt; 0 then
   begin //found Netscape 
    BrowserStr := 'Netscape Comunicator';
     PlugInName := Copy(OpenBrowser, 1, Pos('NETSCAPE.EXE',
       uppercase(trim(OpenBrowser))) - 1);
     PluginName := PlugInName + 'Plugins\NPSWF32.dll';
   end
   else
   //found IEExplorer 
  begin
     BrowserStr := 'Internet Explorer';
 
     DPChar := StrAlloc(255);
     GetSystemDirectory(DPChar, 255);
     PluginName := DPChar + '\Macromed\Flash\swflash.ocx';
     DPChar     := nil;
   end;
 
   GetVersion(pluginName);
 
   //returned Version Number, may be checked 
  while mainVersion &lt; 4 do
   begin
     if messagedlg(Text[2], mtInformation, [mbYes, mbNo], 0) = 6 then
     begin
       //installFlash; 
    end
     // if message 
    else
       halt;
 
     getVersion(pluginName);
   end; // while mainVer 
end.
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
