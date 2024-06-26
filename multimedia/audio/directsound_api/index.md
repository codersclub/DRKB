---
Title: Как использовать в своей программе API DirectSound и DirectSound3D?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Как использовать в своей программе API DirectSound и DirectSound3D?
===================================================================

Вариант 1:

Представляю вашему вниманию рабочий пример использования DirectSound на
Delphi + несколько полезных процедур. В этом примере создается один
первичный SoundBuffer и 2 статических, вторичных; в них загружаются 2
WAV файла.

Первичный буфер создается процедурой
AppCreateWritePrimaryBuffer, а любой вторичный -
AppCreateWritePrimaryBuffer. Так как вторичный буфер связан с WAV
файлом, то при создании буфера нужно определить его параметры в
соответствии со звуковым файлом, эти характеристики (Samples, Bits,
IsStereo) задаются в виде параметров процедуры. Time - время WAV\'файл в
секундах (округление в сторону увеличения). При нажатии на кнопку
происходит микширование из вторичных буферов в первичный.
AppWriteDataToBuffer позволяет записать в буфер PCM сигнал. Процедура
CopyWAVToBuffer открывает WAV файл, отделяет заголовок, читает чанк
\'data\' и копирует его в буфер (при этом сначала считывается размер
данных, так как в некоторых WAV файлах существует текстовый довесок, и
если его не убрать, в динамиках возможен треск).

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
        { Private declarations }
        DirectSound : IDirectSound;
        DirectSoundBuffer : IDirectSoundBuffer;
        SecondarySoundBuffer : array[0..1] of IDirectSoundBuffer;
        procedure AppCreateWritePrimaryBuffer;
        procedure AppCreateWriteSecondaryBuffer(var Buffer: IDirectSoundBuffer;
          SamplesPerSec: Integer; Bits: Word; isStereo:Boolean; Time: Integer);
        procedure AppWriteDataToBuffer(Buffer: IDirectSoundBuffer;
          OffSet: DWord; var SoundData; SoundBytes: DWord);
        procedure CopyWAVToBuffer(name: PChar; var Buffer: IDirectSoundBuffer);
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
      AppCreateWriteSecondaryBuffer(SecondarySoundBuffer[0], 22050,8,False,10);
      AppCreateWriteSecondaryBuffer(SecondarySoundBuffer[1], 22050,16,True,1);
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    var
      i: ShortInt;
    begin
      if Assigned(DirectSoundBuffer) then
        DirectSoundBuffer.Release;
      for i:=0 to 1 do
        if Assigned(SecondarySoundBuffer[i]) then
          SecondarySoundBuffer[i].Release;
      if Assigned(DirectSound) then
        DirectSound.Release;
    end;
     
    procedure TForm1.AppWriteDataToBuffer;
    var
      AudioPtr1, AudioPtr2 : Pointer;
      AudioBytes1, AudioBytes2 : DWord;
      h : HResult;
      Temp : Pointer;
    begin
      H:=Buffer.Lock(OffSet, SoundBytes, AudioPtr1, AudioBytes1, AudioPtr2, AudioBytes2, 0);
      if H = DSERR_BUFFERLOST then
      begin
        Buffer.Restore;
        if Buffer.Lock(OffSet, SoundBytes, AudioPtr1, AudioBytes1, AudioPtr2, AudioBytes2, 0) <> DS_OK then
          raise Exception.Create('Unable to Lock Sound Buffer');
      end
      else
      if H <> DS_OK then
        raise Exception.Create('Unable to Lock Sound Buffer');
      Temp := @SoundData;
      Move(Temp^, AudioPtr1^, AudioBytes1);
      if AudioPtr2 <> nil then
      begin
        Temp := @SoundData; Inc(Integer(Temp), AudioBytes1);
        Move(Temp^, AudioPtr2^, AudioBytes2);
      end;
      if Buffer.UnLock(AudioPtr1, AudioBytes1,AudioPtr2, AudioBytes2) <> DS_OK then
        raise Exception.Create('Unable to UnLock Sound Buffer');
    end;
     
    procedure TForm1.AppCreateWritePrimaryBuffer;
    var
      BufferDesc: DSBUFFERDESC;
      Caps: DSBCaps;
      PCM: TWaveFormatEx;
    begin
      FillChar(BufferDesc, SizeOf(DSBUFFERDESC),0);
      FillChar(PCM, SizeOf(TWaveFormatEx),0);
      with BufferDesc do
      begin
        PCM.wFormatTag:=WAVE_FORMAT_PCM;
        PCM.nChannels:=2;
        PCM.nSamplesPerSec:=22050;
        PCM.nBlockAlign:=4;
        PCM.nAvgBytesPerSec:=PCM.nSamplesPerSec * PCM.nBlockAlign;
        PCM.wBitsPerSample:=16;
        PCM.cbSize:=0;
        dwSize:=SizeOf(DSBUFFERDESC);
        dwFlags:=DSBCAPS_PRIMARYBUFFER;
        dwBufferBytes:=0;
        lpwfxFormat:=nil;
      end;
      if DirectSound.SetCooperativeLevel(Handle,DSSCL_WRITEPRIMARY) <> DS_OK then
        raise Exception.Create('Unable to set Coopeative Level');
      if DirectSound.CreateSoundBuffer(BufferDesc,DirectSoundBuffer,nil) <> DS_OK then
        raise Exception.Create('Create Sound Buffer failed');
      if DirectSoundBuffer.SetFormat(PCM) <> DS_OK then
        raise Exception.Create('Unable to Set Format ');
      if DirectSound.SetCooperativeLevel(Handle,DSSCL_NORMAL) <> DS_OK then
        raise Exception.Create('Unable to set Coopeative Level');
    end;
     
    procedure TForm1.AppCreateWriteSecondaryBuffer;
    var
      BufferDesc: DSBUFFERDESC;
      Caps: DSBCaps;
      PCM: TWaveFormatEx;
    begin
      FillChar(BufferDesc, SizeOf(DSBUFFERDESC),0);
      FillChar(PCM, SizeOf(TWaveFormatEx),0);
      with BufferDesc do
      begin
        PCM.wFormatTag:=WAVE_FORMAT_PCM;
        if isStereo then
          PCM.nChannels:=2
        else
          PCM.nChannels:=1;
        PCM.nSamplesPerSec:=SamplesPerSec;
        PCM.nBlockAlign:=(Bits div 8)*PCM.nChannels;
        PCM.nAvgBytesPerSec:=PCM.nSamplesPerSec * PCM.nBlockAlign;
        PCM.wBitsPerSample:=Bits;
        PCM.cbSize:=0;
        dwSize:=SizeOf(DSBUFFERDESC);
        dwFlags:=DSBCAPS_STATIC;
        dwBufferBytes:=Time*PCM.nAvgBytesPerSec;
        lpwfxFormat:=@PCM;
      end;
      if DirectSound.CreateSoundBuffer(BufferDesc,Buffer,nil) <> DS_OK then
        raise Exception.Create('Create Sound Buffer failed');
    end;
     
    procedure TForm1.CopyWAVToBuffer;
    var
      Data : PChar;
      FName : TFileStream;
      DataSize : DWord;
      Chunk : string[4];
      Pos : Integer;
    begin
      FName:=TFileStream.Create(name,fmOpenRead);
      Pos:=24;
      SetLength(Chunk,4);
      repeat
        FName.Seek(Pos, soFromBeginning);
        FName.read(Chunk[1],4);
        Inc(Pos);
      until
        Chunk = 'data';
      FName.Seek(Pos+3, soFromBeginning);
      FName.read(DataSize, SizeOf(DWord));
      GetMem(Data,DataSize);
      FName.read(Data^, DataSize);
      FName.Free;
      AppWriteDataToBuffer(Buffer,0,Data^,DataSize);
      FreeMem(Data,DataSize);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      CopyWAVToBuffer('1.wav',SecondarySoundBuffer[0]);
      CopyWAVToBuffer('flip.wav',SecondarySoundBuffer[1]);
     
      if SecondarySoundBuffer[0].Play(0,0,0) <> DS_OK then
        ShowMessage('Can not play the Sound');
     
      if SecondarySoundBuffer[1].Play(0,0,0) <> DS_OK then
        ShowMessage('Can not play the Sound');
    end;
     
    end.

------------------------------------------------

Вариант 2:

Представляю вашему вниманию очередной пример работы с DirectSound на
Delphi. В этом примере показан принцип работы с 3D буфером. Итак,
процедуры AppCreateWritePrimaryBuffer, AppWriteDataToBuffer,
CopyWAVToBuffer я оставил без изменения (см. письма с до этого).
Процедура AppCreateWriteSecondary3DBuffer является полным аналогом
процедуры AppCreateWriteSecondaryBuffer, за исключением флага
DSBCAPS\_CTRL3D, который указывает на то, что со статическим вторичным
буфером будет связан еще один буфер - SecondarySound3DBuffer. Чтобы его
инициализировать, а также установить некоторые начальные значения
(положение в пространстве, скорость и .т.д.) вызывается процедура
AppSetSecondary3DBuffer, в качестве параметров которой передаются сам
SecondarySoundBuffer и связанный с ним SecondarySound3DBuffer. В этой
процедуре SecondarySound3DBuffer инициализируется с помощью метода
QueryInterface c соответствующим флагом. Кроме того, здесь же
устанавливается положение источника звука в пространстве:
SetPosition(Pos,1,1,0). X,Y,Z Таким образом в начальный момент времени
источник находится на высоте 1 м (ось Y направлена вертикально вверх, а
ось Z - "в экран"). Если смотреть сверху :

    ^ Z
    |
    |
    |
    O----------------> X

Точка O (фактически вы) имеет координаты (0,0), источник звука А(-25,1).
Разумеется понятие "метр" весьма условно. При нажатии на кнопку в
буфер SecondarySoundBuffer загружается звук \'xhe4.wav\'. Это звук
работающего винта вертолета, его длина (звука) ровно 3.99 с (а размер
буфера ровно 4 с). Далее происходит микширование из вторичного буфера в
первичный с флагом DSBPLAY\_LOOPING, что позволяет сделать многократно
повторяющийся звук; время в 0.01 с ухом практически не улавливается и
получается непрерывный звук летящего вертолета. После этого запускется
таймер (поле INTERVAL в Инспекторе Оъектов установлено в 1). Разумеется
вам совсем необязательно делать именно так, это просто пример. В
процедуре Timer1Timer просто меняется координата X с шагом 0.1. В итоге
получаем летящий вертолет слева направо. Заодно можете проверить,
правильно ли у вас расположены колонки.

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
        procedure Timer1Timer(Sender: TObject);
      private
        { Private declarations }
        DirectSound : IDirectSound;
        DirectSoundBuffer : IDirectSoundBuffer;
        SecondarySoundBuffer : IDirectSoundBuffer;
        SecondarySound3DBuffer : IDirectSound3DBuffer;
        procedure AppCreateWritePrimaryBuffer;
        procedure AppCreateWriteSecondary3DBuffer(var Buffer: IDirectSoundBuffer;
        SamplesPerSec: Integer;
        Bits: Word;
        isStereo:Boolean;
        Time: Integer);
        procedure AppSetSecondary3DBuffer(var Buffer: IDirectSoundBuffer;
        var _3DBuffer: IDirectSound3DBuffer);
        procedure AppWriteDataToBuffer(Buffer: IDirectSoundBuffer;
        OffSet: DWord; var SoundData;
        SoundBytes: DWord);
        procedure CopyWAVToBuffer(name: PChar; var Buffer: IDirectSoundBuffer);
      public
        { Public declarations }
    end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      Result: HResult;
    begin
      if DirectSoundCreate(nil, DirectSound, nil) <> DS_OK then
        raise Exception.Create('Failed to create IDirectSound object');
      AppCreateWritePrimaryBuffer;
      AppCreateWriteSecondary3DBuffer(SecondarySoundBuffer, 22050,8,False,4);
      AppSetSecondary3DBuffer(SecondarySoundBuffer, SecondarySound3DBuffer);
      Timer1.Enabled:=False;
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    var
      i: ShortInt;
    begin
      if Assigned(DirectSoundBuffer) then
        DirectSoundBuffer.Release;
      if Assigned(SecondarySound3DBuffer) then
        SecondarySound3DBuffer.Release;
      if Assigned(SecondarySoundBuffer) then
        SecondarySoundBuffer.Release;
      if Assigned(DirectSound) then
        DirectSound.Release;
    end;
     
    procedure TForm1.AppCreateWritePrimaryBuffer;
    var
      BufferDesc: DSBUFFERDESC;
      Caps: DSBCaps;
      PCM: TWaveFormatEx;
    begin
      FillChar(BufferDesc, SizeOf(DSBUFFERDESC),0);
      FillChar(PCM, SizeOf(TWaveFormatEx),0);
      with BufferDesc do
      begin
        PCM.wFormatTag:=WAVE_FORMAT_PCM;
        PCM.nChannels:=2;
        PCM.nSamplesPerSec:=22050;
        PCM.nBlockAlign:=4;
        PCM.nAvgBytesPerSec:=PCM.nSamplesPerSec * PCM.nBlockAlign;
        PCM.wBitsPerSample:=16;
        PCM.cbSize:=0;
        dwSize:=SizeOf(DSBUFFERDESC);
        dwFlags:=DSBCAPS_PRIMARYBUFFER;
        dwBufferBytes:=0;
        lpwfxFormat:=nil;
      end;
      if DirectSound.SetCooperativeLevel(Handle,DSSCL_WRITEPRIMARY) <> DS_OK then
        raise Exception.Create('Unable to set Cooperative Level');
      if DirectSound.CreateSoundBuffer(BufferDesc,DirectSoundBuffer,nil) <> DS_OK then
        raise Exception.Create('Create Sound Buffer failed');
      if DirectSoundBuffer.SetFormat(PCM) <> DS_OK then
        raise Exception.Create('Unable to Set Format ');
      if DirectSound.SetCooperativeLevel(Handle,DSSCL_NORMAL) <> DS_OK then
        raise Exception.Create('Unable to set Cooperative Level');
    end;
     
    procedure TForm1.AppCreateWriteSecondary3DBuffer;
    var
      BufferDesc: DSBUFFERDESC;
      Caps: DSBCaps;
      PCM: TWaveFormatEx;
    begin
      FillChar(BufferDesc, SizeOf(DSBUFFERDESC),0);
      FillChar(PCM, SizeOf(TWaveFormatEx),0);
      with BufferDesc do
      begin
        PCM.wFormatTag:=WAVE_FORMAT_PCM;
        if isStereo then
          PCM.nChannels:=2
        else
          PCM.nChannels:=1;
        PCM.nSamplesPerSec:=SamplesPerSec;
        PCM.nBlockAlign:=(Bits div 8)*PCM.nChannels;
        PCM.nAvgBytesPerSec:=PCM.nSamplesPerSec * PCM.nBlockAlign;
        PCM.wBitsPerSample:=Bits;
        PCM.cbSize:=0;
        dwSize:=SizeOf(DSBUFFERDESC);
        dwFlags:=DSBCAPS_STATIC or DSBCAPS_CTRL3D;
        dwBufferBytes:=Time*PCM.nAvgBytesPerSec;
        lpwfxFormat:=@PCM;
      end;
      if DirectSound.CreateSoundBuffer(BufferDesc, Buffer, nil) <> DS_OK then
        raise Exception.Create('Create Sound Buffer failed');
    end;
     
    procedure TForm1.AppWriteDataToBuffer;
    var
      AudioPtr1, AudioPtr2 : Pointer;
      AudioBytes1, AudioBytes2 : DWord;
      h : HResult;
      Temp : Pointer;
    begin
      H:=Buffer.Lock(OffSet, SoundBytes, AudioPtr1, AudioBytes1,
      AudioPtr2, AudioBytes2, 0);
      if H = DSERR_BUFFERLOST then
      begin
        Buffer.Restore;
        if Buffer.Lock(OffSet, SoundBytes, AudioPtr1, AudioBytes1, AudioPtr2, AudioBytes2, 0) <> DS_OK then
          raise Exception.Create('Unable to Lock Sound Buffer');
      end
      else
      if H <> DS_OK then
        raise Exception.Create('Unable to Lock Sound Buffer');
      Temp:=@SoundData;
      Move(Temp^, AudioPtr1^, AudioBytes1);
      if AudioPtr2 <> nil then
      begin
        Temp:=@SoundData; Inc(Integer(Temp), AudioBytes1);
        Move(Temp^, AudioPtr2^, AudioBytes2);
      end;
      if Buffer.UnLock(AudioPtr1, AudioBytes1, AudioPtr2, AudioBytes2) <> DS_OK then
        raise Exception.Create('Unable to UnLock Sound Buffer');
    end;
     
    procedure TForm1.CopyWAVToBuffer;
    var
      Data : PChar;
      FName : TFileStream;
      DataSize : DWord;
      Chunk : string[4];
      Pos : Integer;
    begin
      FName:=TFileStream.Create(name,fmOpenRead);
      Pos:=24;
      SetLength(Chunk,4);
      repeat
        FName.Seek(Pos, soFromBeginning);
        FName.read(Chunk[1],4);
        Inc(Pos);
      until
        Chunk = 'data';
      FName.Seek(Pos+3, soFromBeginning);
      FName.read(DataSize, SizeOf(DWord));
      GetMem(Data,DataSize);
      FName.read(Data^, DataSize);
      FName.Free;
      AppWriteDataToBuffer(Buffer,0,Data^,DataSize);
      FreeMem(Data,DataSize);
    end;
     
    var
      Pos: Single = -25;
     
    procedure TForm1.AppSetSecondary3DBuffer;
    begin
      if Buffer.QueryInterface(IID_IDirectSound3DBuffer, _3DBuffer) <> DS_OK then
        raise Exception.Create('Failed to create IDirectSound3D object');
      if _3DBuffer.SetPosition(Pos,1,1,0) <> DS_OK then
        raise Exception.Create('Failed to set IDirectSound3D Position');
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      CopyWAVToBuffer('xhe4.wav',SecondarySoundBuffer);
     
      if SecondarySoundBuffer.Play(0,0,DSBPLAY_LOOPING) <> DS_OK then
        ShowMessage('Can not play the Sound');
     
      Timer1.Enabled:=True;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      SecondarySound3DBuffer.SetPosition(Pos,1,1,0);
      Pos:=Pos + 0.1;
    end;
     
    end.

