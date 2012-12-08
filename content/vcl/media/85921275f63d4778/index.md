---
Title: Установить звук для TMediaPlayer
Date: 01.01.2007
---


Установить звук для TMediaPlayer
================================

::: {.date}
01.01.2007
:::

    uses
       MPlayer, MMSystem;
     
     const
       MCI_SETAUDIO = $0873;
       MCI_DGV_SETAUDIO_VOLUME = $4002;
       MCI_DGV_SETAUDIO_ITEM = $00800000;
       MCI_DGV_SETAUDIO_VALUE = $01000000;
       MCI_DGV_STATUS_VOLUME = $4019;
     
     type
       MCI_DGV_SETAUDIO_PARMS = record
         dwCallback: DWORD;
         dwItem: DWORD;
         dwValue: DWORD;
         dwOver: DWORD;
         lpstrAlgorithm: PChar;
         lpstrQuality: PChar;
       end;
     
     type
       MCI_STATUS_PARMS = record
         dwCallback: DWORD;
         dwReturn: DWORD;
         dwItem: DWORD;
         dwTrack: DWORD;
       end;
     
     procedure SetMPVolume(MP: TMediaPlayer; Volume: Integer);
       { Volume: 0 - 1000 }
     var
       p: MCI_DGV_SETAUDIO_PARMS;
     begin
       { Volume: 0 - 1000 }
       p.dwCallback := 0;
       p.dwItem := MCI_DGV_SETAUDIO_VOLUME;
       p.dwValue := Volume;
       p.dwOver := 0;
       p.lpstrAlgorithm := nil;
       p.lpstrQuality := nil;
       mciSendCommand(MP.DeviceID, MCI_SETAUDIO,
         MCI_DGV_SETAUDIO_VALUE or MCI_DGV_SETAUDIO_ITEM, Cardinal(@p));
     end;
     
     function GetMPVolume(MP: TMediaPlayer): Integer;
     var
        p: MCI_STATUS_PARMS;
     begin
       p.dwCallback := 0;
       p.dwItem := MCI_DGV_STATUS_VOLUME;
       mciSendCommand(MP.DeviceID, MCI_STATUS, MCI_STATUS_ITEM, Cardinal(@p));
       Result := p.dwReturn;
       { Volume: 0 - 1000 }
     end;
     
     // Example, Beispiel: 
     
    procedure TForm1.Button1Click(Sender: TObject);
     begin
       SetMPVolume(MediaPlayer1, 500);
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
