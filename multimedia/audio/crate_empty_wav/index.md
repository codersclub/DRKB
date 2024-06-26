---
Title: Создание пустого wav-файла
Date: 01.01.2007
---


Создание пустого wav-файла
==========================

Вариант 1:

> Как мне создать пустой wav-файл? Это просто пустой двоичный файл?

The TMediaPlayer может открыть звуковой файл, если он содержит, по
крайней мере, один байт данных. Я обнаружил это, когда с помощью данного
компонента пытался создать и открыть звуковой файл, содержащий только
заголовок звукового файла. The TMediaplayer не захотел этого делать.

Нижеприведенный код создаст звуковой файл размером 1 байт. Конечно это
криво, но это работает. Вам необходимо лишь добавить MMSYSTEM ко всем
модулям, использующим данную функцию.

    function CreateNewWave(NewFileName: string): Boolean;
     
    var
      DeviceID: Word;
      Return: LongInt;
      MciOpen: TMCI_Open_Parms;
      MciRecord: TMCI_Record_Parms;
      MciPlay: TMCI_Play_Parms;
      MciSave: TMCI_SaveParms;
      MCIResult: LongInt;
      Flags: Word;
      TempFileName: array[0..255] of char;
     
    begin
      MediaPlayer.Close;
     
      StrPCopy(TempFileName, NewFileName);
      MciOpen.lpstrDeviceType := 'waveaudio';
      MciOpen.lpstrElementName := '';
      Flags := Mci_Open_Element or Mci_Open_Type;
      MCIResult := MciSendCommand(0, MCI_OPEN, Flags, LongInt(@MciOpen));
     
      DeviceID := MciOpen.wDeviceId;
     
      MciRecord.dwTo := 1;
      Flags := Mci_To or Mci_Wait;
      MCIResult := MciSendCommand(DeviceID, Mci_Record, Flags, LongInt(@MciRecord));
     
      mciPlay.dwFrom := 0;
      Flags := Mci_From or Mci_Wait;
      MciSendCommand(DeviceId, Mci_Play, Flags, LongInt(@MciPlay));
     
      mciSave.lpfileName := TempFilename;
      Flags := MCI_Save_File or Mci_Wait;
      MCIResult := MciSendCommand(DeviceID, MCI_Save, Flags, LongInt(@MciSave));
     
      Result := MciSendCommand(DeviceID, Mci_Close, 0, LongInt(nil)) = 0;
    end;

----------------------------------------------------------

Вариант 2:

Author: Nick Hodges

Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com) Сборник Kuliba

> Как мне очистить содержимое Wav-файла? Просто заново создать пустой?

Вот небольшой компонент, позволяющий стирать любую часть wave-файла:

    unit Nickmp;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, MPlayer, MMSystem;
     
    type
      TNickMediaPlayer = class(TMediaPlayer)
      private
    { Private declarations }
      protected
    { Protected declarations }
      public
    { Public declarations }
        function DeleteWaveChunk(aFrom, aTo: LongInt): Longint;
      published
    { Published declarations }
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('Samples', [TNickMediaPlayer]);
    end;
     
    function TNickMediaPlayer.DeleteWaveChunk(aFrom, aTo: LongInt): Longint;
    var
      DeleteParms: TMCI_WAVE_DELETE_PARMS;
      Flags: LongInt;
    begin
      Flags := 0;
     
      if Wait then Flags := mci_Wait;
      if Notify then Flags := Flags or mci_Notify;
      DeleteParms.dwCallback := Handle;
      Flags := Flags or mci_From;
      DeleteParms.dwFrom := aFrom;
      Flags := Flags or mci_To;
      DeleteParms.dwTo := aTo;
      Result := mciSendCommand(DeviceID, mci_Delete, Flags, Longint(@DeleteParms));
    end;
     
    end.

