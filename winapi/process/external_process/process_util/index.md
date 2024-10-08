---
Title: Unit с полезными функциями для работы с процессами
Author: Alex Kantchev, stoma@bitex.bg
Date: 05.06.2002
---

Unit с полезными функциями для работы с процессами
==================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Unit с полезными функциями для работы с процессами
     
    Этот Unit содержит полезные функции для работы с процессами. Взять информацию о данном процессе, обо всех процессах, убить процесс, и т.д. Полезна при создании системных приложений под Win32. Надо хорошо оттестировать этот Unit.
     
    Зависимости: windows, PSAPI, TlHelp32, SysUtils;
    Автор:       Alex Kantchev, stoma@bitex.bg
    Copyright:   Моя разработка, некоторые функции базируются на примере в MSDN jan 2000 Collection
    Дата:        5 июня 2002 г.
    ********************************************** }
     
    unit ProcUtilz;
     
    interface
    uses windows, PSAPI, TlHelp32, SysUtils;
     
    type TLpModuleInfo = packed record
      ModuleInfo:LPMODULEINFO;
      ModulePID: Cardinal;
      ModuleName: String;
    end;
     
    type TLpModuleInfoArray = Array of TLpModuleInfo;
     
     
    function RegisterServiceProcess(dwProcessID, dwType: Integer): Integer; stdcall;
                                    external 'KERNEL32.DLL';
    function DisplayProcessInThreeFingerSalute(PID:Integer; Disp:Boolean):Boolean;
    function TakeProcessID (WindowTitle:String):Integer;
    function GetCurrAppPID:Integer;
    function GetAllProcessesInfo(ExtractFullPath: Boolean = false):TLpModuleInfoArray;
    function ExtractExeFromModName(ModuleName: String):String;
    function TerminateTask(PID:integer):integer;
     
    implementation
     
    //Wziat PID na danoi process ot nego window title
    function TakeProcessID(WindowTitle:String):Integer;
    var
      WH:THandle;
    begin
      result := 0;
      WH := FindWindow (nil, pchar(WindowTitle));
      IF WH <> 0 then
        GetWindowThreadProcessID(WH, @Result);
    end;
     
     
    //Wziat PID na tekuchii process
    function GetCurrAppPID:Integer;
    begin
    GetCurrAppPID := GetCurrentProcessID;
    end;
     
    //Pokzat process s PID v task menagera Windows 9X
    //WNIMANIE: Rabotaet tolko pod Win9x !!!!
    function DisplayProcessInThreeFingerSalute(PID:Integer; Disp:Boolean):Boolean;
    begin
     result := false;
     if Win32Platform = VER_PLATFORM_WIN32_WINDOWS then
      begin
       try
        IF Disp=True then
         RegisterServiceProcess(PID, 0)
        else
         RegisterServiceProcess(PID, 1);
        except
         result := false;
       end;
      end;
     DisplayProcessInThreeFingerSalute := result;
    end;
     
    //Ostanavlivaet rabotu procesa. Ne rabotaet so WinNT
    //serviznae processi.
    function TerminateTask(PID:integer):integer;
    var
      process_handle:integer;
      lpExitCode:Cardinal;
    begin
      process_handle:=openprocess(PROCESS_ALL_ACCESS,true,pid);
      GetExitCodeProcess(process_handle,lpExitCode);
      if (process_handle = 0) then
        TerminateTask := GetLastError
      else if terminateprocess(process_handle,lpExitCode) then
       begin
        TerminateTask:=0;
        CloseHandle(process_handle);
       end
      else
       begin
        TerminateTask := GetLastError;
        CloseHandle(process_handle);
       end;
    end;
     
    //Wziat informacia ob processse po ego PID
    //Testirano pod WinNT.
    function GetProcessInfo(PID: WORD):LPMODULEINFO;
    var
     RetVal: LPMODULEINFO;
     hProc: DWORD;
     hMod: HMODULE;
     cm:cardinal;
    begin
     hProc := OpenProcess(PROCESS_QUERY_INFORMATION or PROCESS_VM_READ,false, PID);
     GetMem(RetVal,sizeOf(LPMODULEINFO));
     if not(hProc = 0) then
      begin
       EnumProcessModules(hProc, @hMod, 4, cm);
       GetModuleInformation(hProc,hMod,RetVal,SizeOf(RetVal));
      end;
     GetProcessInfo := RetVal;
    end;
     
    //Wziat executable processa ot ego polnai put
    function ExtractExeFromModName(ModuleName: String):String;
    begin
     ExtractExeFromModName := Copy(ModuleName,LastDelimiter('\',ModuleName)+1,Length(ModuleName));;
    end;
     
    //Wziat informacia ob wse processi rabotaushtie w tekuchii
    //moment. Testirano pod WinNT
    function GetAllProcessesInfo(ExtractFullPath: Boolean = false):TLpModuleInfoArray;
    var
     ProcList: Array [0..$FFF] of DWORD;
     RetVal: TLpModuleInfoArray;
     ProcCnt: Cardinal;
     I,MaxCnt: WORD;
     ModName:array[0..max_path] of char;
     ph,mh: THandle;
     cm: Cardinal;
     SnapShot:THandle;
     ProcEntry:TProcessEntry32;
     RetValLength,CVal: WORD;
     ModInfo:LPMODULEINFO;
    begin
      //case the platform is Win9X
      if Win32Platform = VER_PLATFORM_WIN32_WINDOWS then begin
        GetMem(ModInfo,SizeOf(LPMODULEINFO));
        SnapShot := CreateToolhelp32Snapshot(th32cs_snapprocess, 0);
        RetValLength := 0;
        CVal := 0;
        if not integer(SnapShot)=-1 then
         begin
          ProcEntry.dwSize:=sizeof(TProcessEntry32);
          if Process32First(SnapShot, ProcEntry) then
          repeat
           //get the size of out array
           Inc(RetValLength);
          until not Process32Next(SnapShot, ProcEntry);
          //set the size of the output array
          SetLength(RetVal,RetValLength);
          //iterate through processes and get their info
          if Process32First(SnapShot, ProcEntry) then
          repeat
           begin
            Inc(CVal);
            ModInfo.lpBaseOfDll := nil;
            ModInfo.SizeOfImage := ProcEntry.dwSize;
            ModInfo.EntryPoint := nil;
            RetVal[CVal].ModuleInfo := ModInfo;
            RetVal[CVal].ModulePID := ProcEntry.th32ProcessID;
            if (ExtractFullPath) then
             RetVal[CVal].ModuleName := string(ProcEntry.szExeFile)
            else
             RetVal[CVal].ModuleName := ExtractExeFromModName(string(ProcEntry.szExeFile));
            ModInfo := nil;
           end;
          until not Process32Next(SnapShot, ProcEntry);
        end;
       end
     //case the platform is WinNT/2K/XP
     else
      begin
       EnumProcesses(@ProcList,sizeof(ProcList),ProcCnt);
       MaxCnt := ProcCnt div 4;
       SetLength(RetVal,MaxCnt);
       //iterate through processes and get their info
       for i := Low(RetVal) to High(RetVal) do
        begin
         //Check for reserved PIDs
         if ProcList[i] = 0 then
           begin
            RetVal[i].ModuleName := 'System Idle Process';
            RetVal[i].ModulePID := 0;
            RetVal[i].ModuleInfo := ProcUtilz.GetProcessInfo(i);
           end
          else if ProcList[i] = 8 then
           begin
            RetVal[i].ModuleName := 'System';
            RetVal[i].ModulePID := 8;
            RetVal[i].ModuleInfo := ProcUtilz.GetProcessInfo(i);
          end
          //Gather info about all processes
          else
           begin
            RetVal[i].ModulePID := ProcList[i];
            RetVal[i].ModuleInfo := GetProcessInfo(ProcList[i]);
            //get module name
            ph:=OpenProcess(PROCESS_QUERY_INFORMATION or PROCESS_VM_READ,false, ProcList[i]);
            if ph>0 then
              begin
                EnumProcessModules(ph, @mh, 4, cm);
                GetModuleFileNameEx(ph, mh, ModName, sizeof(ModName));
                if (ExtractFullPath) then
                  RetVal[i].ModuleName := string(ModName)
                else
                  RetVal[i].ModuleName := ExtractExeFromModName(string(ModName));
              end
             else
              RetVal[i].ModuleName := 'UNKNOWN';
            CloseHandle(ph);
           end;
        end;
      end;
      //return the array of LPMODULEINFO structz
      GetAllProcessesInfo := RetVal;
    end;
     
    end. 

Пример использования:

    procedure TForm1.Button1Click(Sender: TObject);
    var
     I: Integer;
     PC: WORD;
    begin
     ListBox1.Clear;
     ProcArr := TLpModuleInfoArray(ProcUtilz.GetAllProcessesInfo);
     PC := 0;
     for i := Low(ProcArr) to High(ProcArr) do
      begin
       ListBox1.Items.Add('Process Name: '+ProcArr[i].ModuleName+' : Proccess ID '+IntToStr(ProcArr[i].ModulePID)+' : Image Size: '+IntToStr( ProcArr[i].ModuleInfo.SizeOfImage));
       Inc(PC);
      end;
     ListBox1.Items.Add('Total process count: '+IntToStr(PC));
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    var
     EC: Integer;
    begin
     EC := ProcUtilz.TerminateTask(ProcArr[ListBox1.ItemIndex].ModulePID);
     if EC=0 then
      MessageDlg('Task terminated successfully!',mtInformation,[mbOK],0)
     else
      MessageDlg('Unable to terminate task! GetLastError() returned: '+IntToStr(EC),mtWarning,[mbOK],0);
     Button1Click(Sender);
    end; 
