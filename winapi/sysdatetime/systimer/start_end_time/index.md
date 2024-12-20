---
Title: Время старта и завершения работы системы
Author: Krid
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Время старта и завершения работы системы
========================================

Вот так можно узнать дату/время загрузки или завершения работы системы
(т.е. когда компьютер был выключен или перезагружен последний раз):

    unit Unit1;
     
    interface
     
    uses
     Windows, Messages, SysUtils, Variants, Classes, Graphics,
     Controls, Forms, Dialogs, StdCtrls;
     
    type
     TForm1 = class(TForm)
      Label1: TLabel;
      Label2: TLabel;
      procedure FormCreate(Sender: TObject);
     private
      { Private declarations }
     public
      { Public declarations }
     end;
     
    var
     Form1: TForm1;
     
    implementation
     
    uses Registry;
     
    {$R *.dfm}
     
     
    type
     
     SYSTEM_TIME_OF_DAY_INFORMATION = record
       BootTime: LARGE_INTEGER;
       CurrentTime: LARGE_INTEGER;
       TimeZoneBias: LARGE_INTEGER;
       CurrentTimeZoneId: ULONG;
     end;
     PSYSTEM_TIME_OF_DAY_INFORMATION = ^SYSTEM_TIME_OF_DAY_INFORMATION;
    
     NTSTATUS = DWORD;
     
    const
     SystemTimeOfDayInformation = 3;
     
    function NtQuerySystemInformation(
               SystemInformationClass:byte; 
               SystemInformation: Pointer;
               SystemInformationLength: ULONG;
               ReturnLength: PULONG): NTSTATUS;
             stdcall; external 'NTDLL.DLL';
     
     
    function SysDateToStr(ST : TSystemTime) : string;
    const
     sDateFmt = 'dddd, d MMMM, yyyy';
    begin
     SetLength(Result, 255);
     GetDateFormat(LOCALE_USER_DEFAULT, 0, @ST, sDateFmt, @result[1], 255);
     SetLength(Result, LStrLen(@result[1]));
    end;
     
    function SysTimeToStr(ST : TSystemTime):string;
    const
     sTimeFmt = 'HH:mm:ss' ;
    begin
     SetLength(result,15);
     GetTimeFormat(LOCALE_USER_DEFAULT,0,@st,sTimeFmt,@result[1],15);
     SetLength(result, StrLen(@result[1]));
    end;
     
    function GetFileTimeToSystemTime(ft:TFileTime):string;
    var
     st,lt:TSystemTime;
     tz:TTimezoneInformation;
    begin
     Result:='';
     if not FileTimeToSystemTime(ft, st) then exit;
     GetTimeZoneInformation(tz);
     SystemTimeToTzSpecificLocalTime(@tz,st,lt);
     Result:=SysDateToStr(lt)+'  at  ' + SysTimeToStr(lt);
    end;
     
    // дата/время последнего выключения (или перезагрузки) системы
    function GetLastSystemShutdown:string; 
    var
     ft:TFileTime;
     reg:TRegistry;
    begin
     Result:='';
     reg:=TRegistry.Create;
     try
      reg.RootKey:=HKEY_LOCAL_MACHINE;
      if (not reg.OpenKeyReadOnly('System\CurrentControlSet\Control\Windows')) then
        exit;
      if (reg.ReadBinaryData('ShutdownTime',ft,sizeof(ft))=0) then
        exit
     finally
      reg.Free
     end;
     Result:= GetFileTimeToSystemTime(ft)
    end;
     
    // дата/время старта системы
    function NtGetBootDateTime:string; 
    var
     sti : SYSTEM_TIME_OF_DAY_INFORMATION;
     status : NTSTATUS;
     ftSystemBoot: FILETIME;
     ST:TSystemTime;
    begin
     Result:='';
     status:=NtQuerySystemInformation(
               SystemTimeOfDayInformation, @sti,
               sizeof(SYSTEM_TIME_OF_DAY_INFORMATION),nil);
     if (status<>NO_ERROR) then exit;
     ftSystemBoot := PFILETIME(@(sti.BootTime))^;
     if FileTimeToLocalFileTime(ftSystemBoot,ftSystemBoot) then
       if FileTimeToSystemTime(ftSystemBoot,ST) then
         Result:=SysDateToStr(ST)+'  at  '+SysTimeToStr(ST)
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     Label1.Caption:='System start: '+NtGetBootDateTime;
     label2.Caption:='Last system shutdown: '+GetLastSystemShutdown;
    end;
     
    end.

PS: работает только в NT и выше.

