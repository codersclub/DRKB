---
Title: Как получить / изменить громкость?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как получить / изменить громкость?
==================================

    procedure GetVolume(var volL, volR: Word);
    var
      hWO: HWAVEOUT;
      waveF: TWAVEFORMATEX;
      vol: DWORD;
    begin
      volL := 0;
      volR := 0;
      // init TWAVEFORMATEX
      FillChar(waveF, SizeOf(waveF), 0);
      // open WaveMapper = std output of playsound
      waveOutOpen(@hWO, WAVE_MAPPER, @waveF, 0, 0, 0);
      // get volume
      waveOutGetVolume(hWO, @vol);
      volL := vol and $FFFF;
      volR := vol shr 16;
      waveOutClose(hWO);
    end;
     
    procedure SetVolume(const volL, volR: Word);
    var
      hWO: HWAVEOUT;
      waveF: TWAVEFORMATEX;
      vol: DWORD;
    begin
      // init TWAVEFORMATEX
      FillChar(waveF, SizeOf(waveF), 0);
      // open WaveMapper = std output of playsound
      waveOutOpen(@hWO, WAVE_MAPPER, @waveF, 0, 0, 0);
      vol := volL + volR shl 16;
      // set volume
      waveOutSetVolume(hWO, vol);
      waveOutClose(hWO);
    end;

