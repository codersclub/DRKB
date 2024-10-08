---
Title: Как получить информацию о дорожке Audio CD?
Date: 01.01.2007
---


Как получить информацию о дорожке Audio CD?
===========================================

Вариант 1:

    unit frmMain;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, MMSystem;
     
    type
      TForm1 = class(TForm)
        Memo1: TMemo;
        Button2: TButton;
        Button3: TButton;
        procedure Button2Click(Sender: TObject);
        procedure Button3Click(Sender: TObject);
      private
        function IsAudioCD(Drive: char): bool;
      public
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    function TForm1.IsAudioCD(Drive: char): bool;
    var
      DrivePath: string;
      MaximumComponentLength: DWORD;
      FileSystemFlags: DWORD;
      VolumeName: string;
    begin
      Result := false;
      DrivePath := Drive + ':\';
      if GetDriveType(PChar(DrivePath)) = DRIVE_CDROM then
      begin
        SetLength(VolumeName, 64);
        GetVolumeInformation(PChar(DrivePath), PChar(VolumeName), Length(VolumeName), nil,
          MaximumComponentLength, FileSystemFlags, nil, 0);
        if lStrCmp(PChar(VolumeName), 'Audio CD') = 0 then
          Result := True;
      end;
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      if IsAudioCD(' D ') then
        showmessage('Cd is an audio cd')
      else
        showmessage('Cd is not an audio cd');
    end;
     
    procedure TForm1.Button3Click(Sender: TObject);
    type
      TDWord = record
        High: Word;
        Low: Word;
      end;
    var
      msp: TMCI_INFO_PARMS;
      MediaString: array[0..255] of char;
      ret: longint;
      I: integer;
      StatusParms: TMCI_STATUS_PARMS;
      MciSetParms: TMCI_SET_PARMS;
      MciOpenParms: TMCI_OPEN_PARMS;
      aDeviceID: MCIDEVICEID;
     
      function GetTheDeviceID: MCIDEVICEID;
      begin
        FillChar(MciOpenParms, SizeOf(MciOpenParms), #0);
        try
          MciOpenParms.lpstrDeviceType := 'cdaudio';
          ret := mciSendCommand(0, MCI_OPEN, MCI_OPEN_TYPE + MCI_OPEN_SHAREABLE,
            LongInt(@MciOpenParms));
          Result := MciOpenParms.wDeviceID;
        except
          on E: Exception do
          begin
            Result := 0;
            showmessage('error receiving deviceIDt' + #13 + SysErrorMessage(GetLastError)
              + #13 + E.Message);
          end;
        end;
      end;
     
      function GetTrackInfo(const uMsg: UInt; const fdwCommand: DWord;
        const dwItem: DWord; const dwTrack: DWord): string;
      begin
        Result := 'Did not work...';
        FillChar(MediaString, SizeOf(MediaString), #0);
        FillChar(StatusParms, SizeOf(StatusParms), #0);
        StatusParms.dwItem := dwItem;
        StatusParms.dwTrack := dwTrack;
        ret := mciSendCommand(aDeviceID, uMsg, fdwCommand, longint(@StatusParms));
        if Ret = 0 then
          Result := IntToStr(StatusParms.dwReturn);
      end;
     
      procedure SetTimeInfo;
      begin
        FillChar(MciSetParms, SizeOf(MciSetParms), #0);
        MciSetParms.dwTimeFormat := MCI_FORMAT_MSF;
        ret := mciSendCommand(aDeviceID {Mp.DeviceId}, MCI_SET, MCI_SET_TIME_FORMAT,
          longint(@MciSetParms));
        if Ret <> 0 then
          Showmessage('Error convering timeformat...');
      end;
     
    begin
      Memo1.Clear;
      aDeviceID := GetTheDeviceID;
      Application.ProcessMessages;
      Memo1.Lines.Add('Track info  :');
      SetTimeInfo;
      Memo1.Lines.Add('Tracks: ' + GetTrackInfo(MCI_STATUS, MCI_STATUS_ITEM,
        MCI_STATUS_NUMBER_OF_TRACKS, 0));
      Memo1.Lines.Add(' ');
      for I := 1 to StrToInt(GetTrackInfo(MCI_STATUS, MCI_STATUS_ITEM,
        MCI_STATUS_NUMBER_OF_TRACKS, 0)) do
      begin
        Memo1.Lines.Add('Track ' + IntToStr(I) + '  :  ' + IntToStr(MCI_MSF_MINUTE
          (StrToInt(GetTrackInfo(MCI_STATUS, MCI_STATUS_ITEM +
          MCI_TRACK, MCI_STATUS_LENGTH, I)))) + ':' +
          IntToStr(MCI_MSF_SECOND(StrToInt(GetTrackInfo(MCI_STATUS,
          MCI_STATUS_ITEM + MCI_TRACK, MCI_STATUS_LENGTH, I)))));
      end;
      Application.ProcessMessages;
    end;
     
    end.

------------------------------------------------------------------------

Вариант 2:

Source: Delphi Knowledge Base: <https://www.baltsoft.com/>

To get the number of tracks and the length of the current track that is
playing, use this code :

    uses
      mmsystem;
     
    procedure GetInfo(mp: TMediaPlayer);
    var
      Trk, Min, Sec: word;
    begin
      with mp do
      begin
        Trk := MCI_TMSF_TRACK(Position);
        Min := MCI_TMSF_MINUTE(Position);
        Sec := MCI_TMSF_SECOND(Position);
      end;
      label1.caption := Format('%.2d/%.2d %.2d:%.2d', [Trk, mp.tracks, min, sec]);
    end;

And if you would like to check for an audio CD, try this code:

    function IsAudioCD(Drive: char): bool;
    var
      DrivePath: string;
      MaximumComponentLength: DWORD;
      FileSystemFlags: DWORD;
      VolumeName: string;
    begin
      Result := false;
      DrivePath := Drive + ':\';
      if GetDriveType(PChar(DrivePath)) <> DRIVE_CDROM then
        exit;
      SetLength(VolumeName, 64);
      GetVolumeInformation(PChar(DrivePath), PChar(VolumeName), Length(VolumeName), nil,
        MaximumComponentLength, FileSystemFlags, nil, 0);
      if lStrCmp(PChar(VolumeName), 'Audio CD') = 0 then
        result := true;
    end;

