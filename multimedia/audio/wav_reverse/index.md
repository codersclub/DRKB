---
Title: Как проиграть wave файл в обратную сторону?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как проиграть wave файл в обратную сторону?
===========================================

    unit Unit1; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms, 
      Dialogs, StdCtrls, MMSystem; 
     
    const 
      WM_FINISHED = WM_USER + $200; 
     
    type 
      TForm1 = class(TForm) 
        Button1: TButton; 
        Button2: TButton; 
        procedure FormCloseQuery(Sender: TObject; var CanClose: Boolean); 
        procedure Button1Click(Sender: TObject); 
        procedure Button2Click(Sender: TObject); 
      private 
        fData: PChar; 
        fWaveHdr: PWAVEHDR; 
        fWaveOutHandle: HWAVEOUT; 
     
        procedure ReversePlay(const szFileName: string); 
        procedure WaveOutProc(hwo: HWAVEOUT; uMsg: UINT; dwParam1, 
          dwParam2: DWORD); 
        procedure WmFinished(var Msg: TMessage); message WM_FINISHED; 
     
        { Private declarations } 
      public 
        { Public declarations } 
      end; 
     
    var 
      Form1: TForm1; 
     
    implementation 
     
    {$R *.dfm} 
     
    procedure Interchange(hpchPos1, hpchPos2: PChar; wLength: Word); 
    var 
      wPlace: word; 
      bTemp: char; 
    begin 
      for wPlace := 0 to wLength - 1 do 
      begin 
        bTemp := hpchPos1[wPlace]; 
        hpchPos1[wPlace] := hpchPos2[wPlace]; 
        hpchPos2[wPlace] := bTemp 
      end 
    end; 
     
    { 
      Callback function to be called during waveform-audio playback 
      to process messages related to the progress of t he playback. 
    } 
     
    procedure waveOutPrc(hwo: HWAVEOUT; uMsg: UINT; dwInstance, 
      dwParam1, dwParam2: DWORD); stdcall; 
    begin 
      TForm1(dwInstance).WaveOutProc(hwo, uMsg, dwParam1, dwParam2) 
    end; 
     
    procedure TForm1.WaveOutProc(hwo: HWAVEOUT; uMsg: UINT; dwParam1, 
      dwParam2: DWORD); 
    begin 
      case uMsg of 
        WOM_OPEN:; 
        WOM_CLOSE: 
          fWaveOutHandle := 0; 
        WOM_DONE: 
          PostMessage(Handle, WM_FINISHED, 0, 0); 
      end 
    end; 
     
    procedure TForm1.ReversePlay(const szFileName: string); 
    var 
      mmioHandle: HMMIO; 
      mmckInfoParent: MMCKInfo; 
      mmckInfoSubChunk: MMCKInfo; 
      dwFmtSize, dwDataSize: DWORD; 
      pFormat: PWAVEFORMATEX; 
      wBlockSize: word; 
      hpch1, hpch2: PChar; 
    begin 
      { The mmioOpen function opens a file for unbuffered or buffered I/O } 
      mmioHandle := mmioOpen(PChar(szFileName), nil, MMIO_READ or MMIO_ALLOCBUF); 
      if mmioHandle = 0 then 
        raise Exception.Create('Unable to open file ' + szFileName); 
     
      try 
        { mmioStringToFOURCC converts a null-terminated string to a four-character code } 
        mmckInfoParent.fccType := mmioStringToFOURCC('WAVE', 0); 
        { The mmioDescend function descends into a chunk of a RIFF file } 
        if mmioDescend(mmioHandle, @mmckinfoParent, nil, MMIO_FINDRIFF) <> 
          MMSYSERR_NOERROR then raise Exception.Create(szFileName + ' is not a valid wave file'); 
     
        mmckinfoSubchunk.ckid := mmioStringToFourCC('fmt ', 0); 
        if mmioDescend(mmioHandle, @mmckinfoSubchunk, @mmckinfoParent, 
          MMIO_FINDCHUNK) <> MMSYSERR_NOERROR then 
          raise Exception.Create(szFileName + ' is not a valid wave file'); 
     
        dwFmtSize := mmckinfoSubchunk.cksize; 
        GetMem(pFormat, dwFmtSize); 
     
        try 
          { The mmioRead function reads a specified number of bytes from a file } 
          if DWORD(mmioRead(mmioHandle, PChar(pFormat), dwFmtSize)) <> 
            dwFmtSize then 
            raise Exception.Create('Error reading wave data'); 
     
          if pFormat^.wFormatTag <> WAVE_FORMAT_PCM then 
            raise Exception.Create('Invalid wave file format'); 
     
          { he waveOutOpen function opens the given waveform-audio output device for playback } 
          if waveOutOpen(@fWaveOutHandle, WAVE_MAPPER, pFormat, 0, 0, 
            WAVE_FORMAT_QUERY) <> MMSYSERR_NOERROR then 
            raise Exception.Create('Cannot play format'); 
     
          mmioAscend(mmioHandle, @mmckinfoSubchunk, 0); 
          mmckinfoSubchunk.ckid := mmioStringToFourCC('data', 0); 
          if mmioDescend(mmioHandle, @mmckinfoSubchunk, @mmckinfoParent, 
            MMIO_FINDCHUNK) <> MMSYSERR_NOERROR then 
            raise Exception.Create('No data chunk'); 
     
          dwDataSize := mmckinfoSubchunk.cksize; 
          if dwDataSize = 0 then 
            raise Exception.Create('Chunk has no data'); 
     
          if waveOutOpen(@fWaveOutHandle, WAVE_MAPPER, pFormat, 
            DWORD(@WaveOutPrc), Integer(Self), CALLBACK_FUNCTION) <> MMSYSERR_NOERROR then 
          begin 
            fWaveOutHandle := 0; 
            raise Exception.Create('Failed to open output device'); 
          end; 
     
          wBlockSize := pFormat^.nBlockAlign; 
     
          ReallocMem(pFormat, 0); 
          ReallocMem(fData, dwDataSize); 
     
          if DWORD(mmioRead(mmioHandle, fData, dwDataSize)) <> dwDataSize then 
            raise Exception.Create('Unable to read data chunk'); 
     
          hpch1 := fData; 
          hpch2 := fData + dwDataSize - 1; 
     
          while hpch1 < hpch2 do 
          begin 
            Interchange(hpch1, hpch2, wBlockSize); 
            Inc(hpch1, wBlockSize); 
            Dec(hpch2, wBlockSize) 
          end; 
     
          GetMem(fWaveHdr, SizeOf(WAVEHDR)); 
          fWaveHdr^.lpData  := fData; 
          fWaveHdr^.dwBufferLength := dwDataSize; 
          fWaveHdr^.dwFlags := 0; 
          fWaveHdr^.dwLoops := 0; 
          fWaveHdr^.dwUser := 0; 
     
          { The waveOutPrepareHeader function prepares a waveform-audio data block for playback. } 
          if waveOutPrepareHeader(fWaveOutHandle, fWaveHdr, 
            SizeOf(WAVEHDR)) <> MMSYSERR_NOERROR then 
            raise Exception.Create('Unable to prepare header'); 
     
          { The waveOutWrite function sends a data block to the given waveform-audio output device.} 
          if waveOutWrite(fWaveOutHandle, fWaveHdr, SizeOf(WAVEHDR)) <> 
            MMSYSERR_NOERROR then 
            raise Exception.Create('Failed to write to device'); 
     
        finally 
          ReallocMem(pFormat, 0) 
        end 
      finally 
        mmioClose(mmioHandle, 0) 
      end 
    end; 
     
    // Play a wave file 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      Button1.Enabled := False; 
      try 
        ReversePlay('C:\myWaveFile.wav') 
      except 
        Button1.Enabled := True; 
        raise 
      end 
    end; 
     
    // Stop Playback 
     
    procedure TForm1.Button2Click(Sender: TObject); 
    begin 
      { The waveOutReset function stops playback on the given waveform-audio output device } 
      WaveOutReset(fWaveOutHandle); 
    end; 
     
    procedure TForm1.WmFinished(var Msg: TMessage); 
    begin 
      WaveOutUnprepareHeader(fWaveOutHandle, fWaveHdr, SizeOf(WAVEHDR)); 
      WaveOutClose(fWaveOutHandle); 
      ReallocMem(fData, 0); 
      ReallocMem(fWaveHdr, 0); 
      Button1.Enabled := True; 
    end; 
     
    procedure TForm1.FormCloseQuery(Sender: TObject; var CanClose: Boolean); 
    begin 
      WaveOutReset(fWaveOutHandle); 
      while fWaveOutHandle <> 0 do 
        Application.ProcessMessages 
    end; 
     
    end. 

