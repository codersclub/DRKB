---
Title: Получение времени удаленного компьютера, Пример использования NetRemoteTOD
Author: Rouse\_
Date: 01.01.2007
---


Получение времени удаленного компьютера, Пример использования NetRemoteTOD
==========================================================================

::: {.date}
01.01.2007
:::

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      end;
     
      PTIME_OF_DAY_INFO = ^TIME_OF_DAY_INFO; 
      TIME_OF_DAY_INFO = record
        tod_elapsedt : DWORD;
        tod_msecs    : DWORD;
        tod_hours    : DWORD;
        tod_mins     : DWORD;
        tod_secs     : DWORD;
        tod_hunds    : DWORD;
        tod_timezone : Longint;
        tod_tinterval: DWORD;
        tod_day      : DWORD;
        tod_month    : DWORD;
        tod_year     : DWORD;
        tod_weekday  : DWORD;
      end;
     
      function NetRemoteTOD(Server: PWChar; var pBuffer: PTIME_OF_DAY_INFO): DWORD;
        stdcall; external 'NETAPI32.DLL';
      function NetApiBufferFree(pBuffer: Pointer): DWORD;
        stdcall; external 'NETAPI32.DLL';
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      TOD: PTIME_OF_DAY_INFO;
    begin
      if NetRemoteTOD('\\192.168.2.108', TOD) = 0 then
      try
        with TOD^ do
          ShowMessage(Format('Data %d %d %d Time %d:%d:%d',
            [tod_day, tod_month, tod_year, tod_hours - (tod_timezone div 60),
              tod_mins, tod_secs]));
      finally
        NetApiBufferFree(TOD);
      end
      else
        RaiseLastOSError;
    end;
     
    end.
     



Взято из <https://forum.sources.ru>

Автор: Rouse\_

 


