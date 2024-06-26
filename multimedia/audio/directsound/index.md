---
Title: Пример использования DirectSound на Delphi
Date: 01.01.2007
Source: <https://blackman.wp-club.net/>
---


Пример использования DirectSound на Delphi
==========================================

рабочий пример использования DirectSound на Delphi + несколько полезных
процедур. В этом примере создается один первичный SoundBuffer и 2
статических, вторичных; в них загружаются 2 WAV файла.

Первичный буфер создается процедурой AppCreateWritePrimaryBuffer,
а любой вторичный - AppCreateWritePrimaryBuffer. Так как
вторичный буфер связан с WAV файлом, то при создании
буфера нужно определить его параметры в соответствии
со звуковым файлом, эти характеристики (Samples, Bits, IsStereo)
задаются в виде параметров процедуры. Time - время WAV\'файла
в секундах (округление в сторону увеличения).

    unit Unit1;
    interface
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, DSound, MMSystem, StdCtrls, ExtCtrls;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        Timer1: TTimer;
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        procedure Button1Click(Sender: TObject);
      private
        DirectSound: IDirectSound;
        DirectSoundBuffer: IDirectSoundBuffer;
        SecondarySoundBuffer: array[0..1] of IDirectSoundBuffer;
        procedure AppCreateWritePrimaryBuffer;
        procedure AppCreateWriteSecondaryBuffer(var Buffer: IDirectSoundBuffer;
          SamplesPerSec: Integer;
          Bits: Word;
          isStereo: Boolean;
          Time: Integer);
        procedure AppWriteDataToBuffer(Buffer: IDirectSoundBuffer;
          OffSet: DWord; var SoundData;
          SoundBytes: DWord);
        procedure CopyWAVToBuffer(Name: PChar; var Buffer: IDirectSoundBuffer);
    { Private declarations }
      public
    { Public declarations }
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      if DirectSoundCreate(nil, DirectSound, nil) <> DS_OK then
        raise Exception.Create('Failed to create IDirectSound object');
      AppCreateWritePrimaryBuffer;
      AppCreateWriteSecondaryBuffer(SecondarySoundBuffer[0], 22050, 8, False, 10);
      AppCreateWriteSecondaryBuffer(SecondarySoundBuffer[1], 22050, 16, True, 1);
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    var i: ShortInt;
    begin
      if Assigned(DirectSoundBuffer) then DirectSoundBuffer.Release;
      for i := 0 to 1 do
        if Assigned(SecondarySoundBuffer[i]) then SecondarySoundBuffer[i].Release;
      if Assigned(DirectSound) then DirectSound.Release;
    end;
     
    procedure TForm1.AppWriteDataToBuffer;
    var
      AudioPtr1, AudioPtr2: Pointer;
      AudioBytes1, AudioBytes2: DWord;
      h: HResult;
      Temp: Pointer;
    begin
      H := Buffer.Lock(OffSet, SoundBytes, AudioPtr1, AudioBytes1,
        AudioPtr2, AudioBytes2, 0);
      if H = DSERR_BUFFERLOST then
        begin
          Buffer.Restore;
          if Buffer.Lock(OffSet, SoundBytes, AudioPtr1, AudioBytes1,
            AudioPtr2, AudioBytes2, 0) <> DS_OK then
            raise Exception.Create('Unable to Lock Sound Buffer');
        end
      else
        if H <> DS_OK then raise Exception.Create('Unable to Lock Sound Buffer');
      Temp := @SoundData;
      Move(Temp^, AudioPtr1^, AudioBytes1);
      if AudioPtr2 <> nil then
        begin
          Temp := @SoundData; Inc(Integer(Temp), AudioBytes1);
          Move(Temp^, AudioPtr2^, AudioBytes2);
        end;
      if Buffer.UnLock(AudioPtr1, AudioBytes1, AudioPtr2, AudioBytes2) <> DS_OK
        then raise Exception.Create('Unable to UnLock Sound Buffer');
    end;
     
    procedure TForm1.AppCreateWritePrimaryBuffer;
    var BufferDesc: DSBUFFERDESC;
      Caps: DSBCaps;
      PCM: TWaveFormatEx;
    begin
      FillChar(BufferDesc, SizeOf(DSBUFFERDESC), 0);
      FillChar(PCM, SizeOf(TWaveFormatEx), 0);
      with BufferDesc do
        begin
          PCM.wFormatTag := WAVE_FORMAT_PCM;
          PCM.nChannels := 2;
          PCM.nSamplesPerSec := 22050;
          PCM.nBlockAlign := 4;
          PCM.nAvgBytesPerSec := PCM.nSamplesPerSec
          PCM.wBitsPerSample := 16;
          PCM.cbSize := 0;
          dwSize := SizeOf(DSBUFFERDESC);
          dwFlags := DSBCAPS_PRIMARYBUFFER;
          dwBufferBytes := 0;
          lpwfxFormat := nil;
        end;
      if DirectSound.SetCooperativeLevel(Handle, DSSCL_WRITEPRIMARY) <> DS_OK
        then raise Exception.Create('Unable to set Coopeative Level');
      if DirectSound.CreateSoundBuffer(BufferDesc, DirectSoundBuffer, nil) <> DS_OK
        then raise Exception.Create('Create Sound Buffer failed');
      if DirectSoundBuffer.SetFormat(PCM) <> DS_OK
        then raise Exception.Create('Unable to Set Format ');
      if DirectSound.SetCooperativeLevel(Handle, DSSCL_NORMAL) <> DS_OK
        then raise Exception.Create('Unable to set Coopeative Level');
    end;
     
    procedure TForm1.AppCreateWriteSecondaryBuffer;
    var BufferDesc: DSBUFFERDESC;
      Caps: DSBCaps;
      PCM: TWaveFormatEx;
    begin
      FillChar(BufferDesc, SizeOf(DSBUFFERDESC), 0);
      FillChar(PCM, SizeOf(TWaveFormatEx), 0);
      with BufferDesc do
        begin
          PCM.wFormatTag := WAVE_FORMAT_PCM;
          if isStereo then
            PCM.nChannels := 2
          else
            PCM.nChannels := 1;
          PCM.nSamplesPerSec := SamplesPerSec;
          PCM.nBlockAlign := (Bits div 8) * PCM.nChannels;
          PCM.nAvgBytesPerSec := PCM.nSamplesPerSec * PCM.nBlockAlign;
          PCM.wBitsPerSample := Bits;
          PCM.cbSize := 0;
          dwSize := SizeOf(DSBUFFERDESC);
          dwFlags := DSBCAPS_STATIC;
          dwBufferBytes := Time * PCM.nAvgBytesPerSec;
          lpwfxFormat := @PCM;
        end;
      if DirectSound.CreateSoundBuffer(BufferDesc, Buffer, nil) <> DS_OK
        then raise Exception.Create('Create Sound Buffer failed');
    end;
     
    procedure TForm1.CopyWAVToBuffer;
    var Data: PChar;
      FName: TFileStream;
      DataSize: DWord;
      Chunk: string[4];
      Pos: Integer;
    begin
      FName := TFileStream.Create(Name, fmOpenRead);
      Pos := 24;
      SetLength(Chunk, 4);
      repeat
        FName.Seek(Pos, soFromBeginning);
        FName.Read(Chunk[1], 4);
        Inc(Pos);
      until Chunk = 'data';
      FName.Seek(Pos + 3, soFromBeginning);
      FName.Read(DataSize, SizeOf(DWord));
      GetMem(Data, DataSize);
      FName.Read(Data^, DataSize);
      FName.Free;
      AppWriteDataToBuffer(Buffer, 0, Data^, DataSize);
      FreeMem(Data, DataSize);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      CopyWAVToBuffer('1.wav', SecondarySoundBuffer[0]);
      CopyWAVToBuffer('flip.wav', SecondarySoundBuffer[1]);
      if SecondarySoundBuffer[0].Play(0, 0, 0) <> DS_OK
        then ShowMessage('Can not play the Sound');
      if SecondarySoundBuffer[1].Play(0, 0, 0) <> DS_OK
        then ShowMessage('Can not play the Sound');
    end;
     
    end.

