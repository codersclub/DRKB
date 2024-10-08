---
Title: Перечислить измененные ключи реестра в определенный диапазон времени
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---

Перечислить измененные ключи реестра в определенный диапазон времени
====================================================================

    unit Main;
     
    interface
    
    uses
      Windows, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, Registry, StdCtrls, ComCtrls, ExtCtrls;
    
    type
      TFrmMain = class(TForm)
        Memo1: TMemo;
        btEnumReg: TButton;
        dtBeginDate: TDateTimePicker;
        dtEndDate: TDateTimePicker;
        dtBeginTime: TDateTimePicker;
        dtEndTime: TDateTimePicker;
        Panel1: TPanel;
        Label1: TLabel;
        Label2: TLabel;
        procedure btEnumRegClick(Sender: TObject);
      private
        { Private declarations }
        RegDate: TDateTime;
        RegKeyInfo: TRegKeyInfo;
        TimeZoneInfo: TTimeZoneInformation;
        function DateTimeToLocalDateTime(DateTime: TDateTime): TDateTime;
        procedure FileTimeToDateTime(ft: TFileTime; var dt: TDateTime);
      public
        { Public declarations }
    
      end;
    
    var
      FrmMain: TFrmMain;
    
    implementation
    
    {$R *.dfm}
    
    function TFrmMain.DateTimeToLocalDateTime(DateTime: TDateTime): TDateTime;
    begin
      case GetTimeZoneInformation(TimeZoneInfo) of
        TIME_ZONE_ID_STANDARD:
          Result := DateTime - (TimeZoneInfo.Bias / 60 / 24);
        TIME_ZONE_ID_DAYLIGHT:
          Result := DateTime - ((TimeZoneInfo.Bias + TimeZoneInfo.DaylightBias) / 60 / 24);
        else
          Result := 0;
      end;
    end;
    
    procedure TFrmMain.FileTimeToDateTime(ft: TFileTime; var dt: TDateTime);
    var
      SystemTime: TSystemTime;
      FileTime: TFileTime;
    begin
      if FileTimeToLocalFileTime(ft, FileTime) then
      begin
        FileTimeToSystemTime(ft, SystemTime);
        dt := SystemTimeToDateTime(SystemTime);
      end;
    end;
    
    procedure TFrmMain.btEnumRegClick(Sender: TObject);
    var
      Inizio, Fine: TDateTime;
    
      procedure EnumAllKeys(hkey: THandle; KeyName: string);
      var
        l: TStringList;
        n: Integer;
        KeyName_: string;
      begin
        KeyName_ := KeyName;
        with TRegistry.Create do
          try
            RootKey := hkey;
            OpenKey(EmptyStr, False);
            l := TStringList.Create;
            try
              GetKeynames(l);
              CloseKey;
              for n := 0 to l.Count - 1 do
              begin
                if OpenKey(l[n], False) then
                begin
                  GetKeyInfo(RegKeyInfo);
                  with RegKeyInfo do
                  begin
                    FileTimeToDateTime(FileTime, RegDate);
                    RegDate := DateTimeToLocalDateTime(RegDate);
                  end;
                  if (RegDate <= Fine) and (RegDate >= Inizio) then
                    memo1.Lines.Add(DateTimeToStr(RegDate) + ' --- ' + KeyName_ + '\' + l[n]);
                  EnumAllKeys(CurrentKey, KeyName_ + '\' + l[n]);
                  CloseKey;
                end;
              end;
            finally
              l.Free
            end;
          finally
            Free;
          end;
      end;
    begin
      Memo1.Clear;
      Memo1.Lines.BeginUpdate;
      Inizio := int(dtBeginDate.DateTime) + frac(dtBeginTime.DateTime);
      Fine   := int(dtEndDate.Date) + frac(dtEndTime.DateTime);
      try
        EnumAllKeys(HKEY_CURRENT_USER, 'HKey_Current_User');
      finally
        Memo1.Lines.EndUpdate;
      end;
    
      MessageDlg('Enumeration ended', mtInformation, [mbOK], 0);
    end;
    
    end.

